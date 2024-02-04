<?php

namespace ChessServer\Socket;

use Workerman\Worker;

class WorkermanWebSocket extends WorkermanSocket
{
    public function __construct(string $port, string $address, array $context)
    {
        parent::__construct();

        $this->worker = new Worker("websocket://$address:$port", $context);
        $this->worker->transport = 'ssl';

        $this->connect()->message()->error()->close();
    }
}