<?php

class Test extends Thread
{

    protected $socket;

    public function __construct($socket)
    {
        $this->socket = $socket;
    }

    public function run()
    {
        
        $client = socket_accept($this->socket);
            
        error_log("Connection accepted by thread: {$this->getThreadId()}");

        $counter = 1;
        $connectionOpen = true;
        $startTime = time();
        
        $timeout = 120;
        $max = 5;
        
        while ($connectionOpen && ($startTime + $timeout) > time()) {
            
            $buffer = '';
            
            while ($buffer .= socket_read($client, 1024)) {
                if (false !== strpos($buffer, "\r\n\r\n")) {
                    break;
                }
            } 
            
            if ($buffer === '') {
                
                socket_close($client);
                $connectionOpen = false;
                
                continue;
            }
    
            $message = '<html><head><title>A Title</title></head><body><img src="some.jpg"><p>A content handled by thread: ' . $this->getThreadId(). '</p></body></html>';
            $contentLength = strlen($message);
            
            $headers = array(
                "HTTP/1.1 200 OK",
                "Content-Type: text/html",
                "Connection: keep-alive",
                "Keep-Alive: max=$max, timeout=$timeout",
                "Content-Length: $contentLength"
            );
            
            $response = array(
                "head" => implode("\r\n", $headers) . "\r\n",
                "body" => $message
            );
            
            socket_write($client, implode("\r\n", $response));
            
            if ($counter++ > $max) {
                
                error_log("Now closing connection");
                
                socket_close($client);
                $connectionOpen = false;
                
            }
        }

        error_log("Successfully closed connection");
        error_log("Successfully closed thread: {$this->getThreadId()}");
    }
}

$workers = array();
$socket = socket_create_listen($argv[1]);

if ($socket) {
    
    $worker = 0;
    
    while (++ $worker < 5) {
        $workers[$worker] = new Test($socket);
        $workers[$worker]->start();
    }
    
    printf("%d threads waiting on port %d", count($workers), $argv[1]);
    
    foreach ($workers as $worker) {
        $worker->join();
    }
}