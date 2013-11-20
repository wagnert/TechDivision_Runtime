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
        $maxRequests = 5;
        
        do {
            
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
            
            $availableRequests = $maxRequests - $counter++;
            $ttl = ($startTime + $timeout) - time();
    
            $message = '<html><head><title>A Title</title></head><body><img src="some.jpg"><p>A content handled by thread: ' . $this->getThreadId(). '</p></body></html>';
            $contentLength = strlen($message);
            
            $headers = array(
                "HTTP/1.1 200 OK",
                "Content-Type: text/html",
                "Content-Length: $contentLength"
            );

            // check if this will be the last requests handled by this thread
            if ($availableRequests > 0 && $ttl > 0) {
                $headers[] = "Connection: keep-alive";
                $headers[] = "Keep-Alive: max=$availableRequests, timeout=$timeout";
            } else {
                $headers[] = "Connection: close";
            }
            
            $response = array(
                "head" => implode("\r\n", $headers) . "\r\n",
                "body" => $message
            );
            
            socket_write($client, implode("\r\n", $response));
            
            // check if this is the last request
            if ($availableRequests <= 0 || $ttl <= 0) {
                
                // if yes, close the socket and end the do/while 
                error_log("TTL: $ttl");
                error_log("Available requests: $availableRequests");
                error_log("Now closing connection for thread: {$this->getThreadId()}");
                
                socket_close($client);
                $connectionOpen = false;
            }
            
        } while ($connectionOpen);

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