<?php

namespace ChessServer\Command\Data\Blocking;

use ChessServer\Command\AbstractBlockingCommand;
use ChessServer\Socket\AbstractSocket;

class AutocompleteWhiteCommand extends AbstractBlockingCommand
{
    public function __construct()
    {
        $this->name = '/autocomplete_white';
        $this->description = 'Autocomplete data for chess players.';
        $this->params = [
            'params' => '<string>',
        ];
    }

    public function validate(array $argv)
    {
        return count($argv) - 1 === count($this->params);
    }

    public function run(AbstractSocket $socket, array $argv, int $id)
    {
        $params = $this->params($argv[1]);

        $this->pool->add(new AutocompleteWhiteTask($params))
            ->then(function ($result) use ($socket, $id) {
                return $socket->getClientStorage()->send([$id], [
                    $this->name => $result,
                ]);
            });
    }
}
