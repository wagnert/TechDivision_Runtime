<?php

// bootstrap the application
require __DIR__ . '/../../bootstrap.php';

use TechDivision\Storage\StackableStorage;
use TechDivision\ServletEngine\StandardSessionManager;
use TechDivision\ServletEngine\DefaultSessionSettings;

class Server extends \Thread
{

    protected $applications;

    public function __construct($applications)
    {
        $this->applications = $applications;
    }

    public function run()
    {

        require APPSERVER_BP . '/app/code/vendor/autoload.php';

        $socket = stream_socket_server("tcp://0.0.0.0:8111", $errno, $errstr);

        $applications = $this->applications;
        $workers = array();

        for ($i = 0; $i < 100; $i++) {
            $workers[$i] = new ServerWorker($socket, $applications);
            $workers[$i]->start();
        }

        while (true) {

            for ($i = 0; $i < 100; $i++) {

                if ($workers[$i]->shouldRestart()) {

                    unset($workers[$i]);

                    echo 'RESTART worker ...' . PHP_EOL;

                    $workers[$i] = new ServerWorker($socket, $applications);
                    $workers[$i]->start();

                    echo 'RESTARTED worker ' . $workers[$i]->getThreadId() . PHP_EOL;
                }
            }
        }
    }
}

class ServerWorker extends \Thread
{

    protected $socket;
    protected $applications;
    protected $shouldRestart;

    public function __construct($socket, $applications)
    {
        $this->socket = $socket;
        $this->applications = $applications;

        $this->shouldRestart = false;
    }

    public function run()
    {

        require APPSERVER_BP . '/app/code/vendor/autoload.php';

        $clients = array();

        $socket = $this->socket;
        $applications = $this->applications;

        $handle = 0;
        $line = '';

        while ($handle < 100) {

            $client = stream_socket_accept($socket);

            if (is_resource($client)) {

                $startLine = fgets($client);

                $messageHeaders = '';

                while ($line != "\r\n") {
                    $line = fgets($client);
                    $messageHeaders .= $line;
                }

    			list ($address, $port) = explode(':', stream_socket_get_name($client, true));


    			$application = $applications[rand(0, sizeof($applications) - 1)];

    			$sessionManager = $application->getSessionManager();
    			$servlet = $application->getServlet();

    			$sessionId = $servlet->service($sessionManager);

                $response = array(
                    "head" => array(
                        "HTTP/1.0 200 OK",
                        "Content-Type: text/html",
                        "Connection: close"
                    ),
                    "body" => array()
                );

    			$response["body"][]="<html>";
    			$response["body"][]="<head>";
    			$response["body"][]="<title>Multithread Sockets PHP ({$address}:{$port})</title>";
    			$response["body"][]="</head>";
    			$response["body"][]="<body>";
    			$response["body"][]="<pre>";
    			$response["body"][]="Session-ID: $sessionId";
    			$response["body"][]="</pre>";
    			$response["body"][]="</body>";
    			$response["body"][]="</html>";
    			$response["body"] = implode("\r\n", $response["body"]);

    			$response["head"][] = sprintf("Content-Length: %d", strlen($response["body"]));
    			$response["head"] = implode("\r\n", $response["head"]);

    			fwrite($client, $response["head"]);
    			fwrite($client, "\r\n\r\n");
    			fwrite($client, $response["body"]);

    			stream_socket_shutdown($client, STREAM_SHUT_RDWR);

                $removedSessions = $sessionManager->collectGarbage();

                if ($removedSessions > 0) {
                    echo 'REMOVED ' . $removedSessions . ' sessions [' . date('Y-m-d: H:i:s') . '] - Thread-ID: ' . $this->getThreadId() . PHP_EOL;
                }
            }

            $handle++;
        }

        $this->shouldRestart = true;

        echo 'FINISHED worker ' . $this->getThreadId() . PHP_EOL;
    }

    public function shouldRestart()
    {
        return $this->shouldRestart;
    }
}

class Application extends Thread
{

    protected $sessionManager;
    protected $servlet;
    protected $run;

    public function __construct($name)
    {
        $this->name = $name;
        $this->run = true;
    }

    public function injectSessionManager($sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }

    public function getSessionManager()
    {
        return $this->sessionManager;
    }

    public function getServlet()
    {
        return $this->servlet;
    }

    public function run()
    {

        $name = $this->name;

        include __DIR__ . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'Servlet.php';

        $this->servlet = new Servlet(10000);

        while ($this->run) {
            $this->wait();
        }
    }
}

$sessionManager = new StandardSessionManager();
$sessionManager->injectSettings(new DefaultSessionSettings());

$applications = array();
$applications[0] = new Application('app_01');
$applications[0]->injectSessionManager($sessionManager);
$applications[0]->start();

$applications[1] = new Application('app_02');
$applications[1]->injectSessionManager($sessionManager);
$applications[1]->start();

$server = new Server($applications);
$server->start();
$server->join();