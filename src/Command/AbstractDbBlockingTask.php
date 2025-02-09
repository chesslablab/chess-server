<?php

namespace ChessServer\Command;

use ChessServer\Db;

abstract class AbstractDbBlockingTask extends AbstractBlockingTask
{
    protected Db $db;

    public function configure()
    {
        $this->db = new Db($this->env['db']);
    }
}
