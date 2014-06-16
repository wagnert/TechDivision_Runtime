<?php

class Servlet
{

    protected $start;
    protected $offset;

    public function __construct($offset)
    {
        $this->start = 0;
        $this->offset = $offset;
    }

    public function service($sessionManager)
    {

        $id = md5(rand(0, $this->offset));

        if ($session = $sessionManager->find($id)) {

            echo "FOUND session $id" . PHP_EOL;

            $session->putData('requests', rand($this->start, $this->offset));

        } else {

            $session = $sessionManager->create($id, 'test_session');
            $session->start();
            $session->putData('username', 'appsever');

            echo "CREATED session with $id" . PHP_EOL;
        }

        return $id;
    }
}