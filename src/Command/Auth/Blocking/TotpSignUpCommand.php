<?php

namespace ChessServer\Command\Auth\Blocking;

use ChessServer\Command\AbstractBlockingCommand;
use ChessServer\Socket\AbstractSocket;

class TotpSignUpCommand extends AbstractBlockingCommand
{
    public function __construct()
    {
        $this->name = '/totp_signup';
        $this->description = 'TOTP sign up URL.';
    }

    public function validate(array $argv)
    {
        return count($argv) - 1 === 0;
    }

    public function run(AbstractSocket $socket, array $argv, int $id)
    {
        $this->pool->add(new TotpSignUpTask())
            ->then(function ($result) use ($socket, $id) {
                return $socket->getClientStorage()->send([$id], [
                    $this->name => $result,
                ]);
            });
    }
}
