<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Database\Capsule\Manager as Capsule;
use Phinx\Db\Adapter\SQLiteAdapter;

class TestSqLiteAdapter extends SQLiteAdapter
{
    public function connect(): void
    {
        // this ensures that our test database uses the same (eloquent capsule) connection so that it's available to our test suite
        if ($this->connection === null) {
            $this->setConnection(Capsule::connection()->getPdo());
        }
    }
}
