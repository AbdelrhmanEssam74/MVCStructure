<?php

namespace PROJECT\Database\Concerns;

use PROJECT\Database\Managers\Contracts\DatabaseManager;

trait ConnectsTo

{
    public function connect(DatabaseManager $databaseManager): void
    {
        $databaseManager->connect();
    }
}