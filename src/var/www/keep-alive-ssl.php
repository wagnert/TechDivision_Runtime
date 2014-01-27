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

        $timeout = 5;

        $client = @stream_socket_accept($this->socket, $timeout, $peername);

        $counter = 1;
        $connectionOpen = true;
        $startTime = time();

        $maxRequests = 5;

        do {
            
            $buffer = '';
            
            while ($buffer .= @fread($client, 1024)) {
                if (false !== strpos($buffer, "\r\n\r\n")) {
                    break;
                }
            }

            $availableRequests = $maxRequests - $counter++;
            echo '$availableRequests = ' . $availableRequests . PHP_EOL;

            $ttl = ($startTime + $timeout) - time();
    
            ob_start();
            require 'phpinfo.php';
            $contentLength = strlen($message = ob_get_clean());
            
            // prepare response headers
            $headers = array(
                "HTTP/1.1 200 OK",
                "Content-Type: text/html",
                "Content-Length: $contentLength"
            );

            // check if this will be the last requests handled by this thread
            if ($availableRequests > 0 && $ttl > 0) {
                $headers[] = "Connection: keep-alive";
                $headers[] = "Keep-Alive: max=$availableRequests, timeout=$timeout, thread={$this->getThreadId()}";
            } else {
                $headers[] = "Connection: close";
            }
            
            // prepare the response head/body
            $response = array(
                "head" => implode("\r\n", $headers) . "\r\n",
                "body" => $message
            );
            
            // write the result back to the socket
            @fwrite($client, implode("\r\n", $response));
            
            // check if this is the last request
            if ($availableRequests <= 0 || $ttl <= 0) {
                
                // if yes, close the socket and end the do/while
                @fclose($client);
                echo "CLOSE CLIENT SOCKET" . PHP_EOL;
                $connectionOpen = false;
            }
            
        } while ($connectionOpen);

    }
}

// generate certificate
$privkey = openssl_pkey_new();
$cert = openssl_csr_new(array(
    "countryName" => "DE",
    "stateOrProvinceName" => "Bavaria",
    "localityName" => "Kolbermoor",
    "organizationName" => "appserver.io",
    "organizationalUnitName" => md5(microtime()),
    "commonName" => "127.0.0.1",
    "emailAddress" => "mail@appserver.io"
), $privkey);
$cert = openssl_csr_sign($cert, null, $privkey, 365);
// generate pem file
$pem = array();
openssl_x509_export($cert, $pem[0]);
openssl_pkey_export($privkey, $pem[1]);
$pem = implode($pem);
// save pem file
$pemfile = './keep-alive-ssl-cert.pem';
file_put_contents($pemfile, $pem);


// check if port was given via arg values
if (!isset($argv[1])) {
    // set 9015 by default
    $argv[1] = 9443;
}

// init workers array
$workers = array();

// create ssl context
$context = @stream_context_create();
stream_context_set_option($context, 'ssl', 'local_cert', $pemfile);
stream_context_set_option($context, 'ssl', 'allow_self_signed', true);
stream_context_set_option($context, 'ssl', 'verify_peer', false);

// create a new socket connection and listen to it
$socketAddress = "ssl://0.0.0.0:$argv[1]";
$socket = @stream_socket_server($socketAddress, $errno, $errstr, STREAM_SERVER_BIND | STREAM_SERVER_LISTEN, $context);
@stream_set_blocking($socket, true);

if ($socket) {
    
    $worker = 0;
    
    while (++ $worker < 5) {
        $workers[$worker] = new Test($socket);
        $workers[$worker]->start();
    }
    
    printf("%d threads waiting on port %d" . PHP_EOL, count($workers), $argv[1]);
    
    foreach ($workers as $worker) {
        $worker->join();
    }
}