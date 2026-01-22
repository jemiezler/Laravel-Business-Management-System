<?php

namespace App\Connections;

use Illuminate\Database\Connection;
use Illuminate\Database\Query\Grammars\MySqlGrammar;
use Illuminate\Database\Query\Processors\Processor;
use PDO;

class DummyConnection extends Connection
{
    public function __construct()
    {
        parent::__construct(
            new PDO('sqlite::memory:'), // dummy PDO
            'dummy',                    // database name
            '',                         // table prefix
            []                          // config
        );
    }

    public function select($query, $bindings = [], $useReadPdo = true)
    {
        return [];
    }

    public function selectOne($query, $bindings = [], $useReadPdo = true)
    {
        return null;
    }

    public function insert($query, $bindings = [])
    {
        return true;
    }

    public function update($query, $bindings = [])
    {
        return 0;
    }

    public function delete($query, $bindings = [])
    {
        return 0;
    }

    public function scalar($query, $bindings = [], $useReadPdo = true)
    {
        return null;
    }

    public function getQueryGrammar()
    {
        return new MySqlGrammar($this);
    }

    public function getPostProcessor()
    {
        return new Processor();
    }
}
