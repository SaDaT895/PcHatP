<?php

return
    [
        'paths' => [
            'migrations' => 'db/migrations',
            // 'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
        ],
        'environments' => [
            'default_migration_table' => 'phinxlog',
            'default_environment' => 'development',
            'development' => [
                'adapter' => 'sqlite',
                'name' => 'db/db',
                'suffix' => 'sqlite'
            ],
            'testing' => [
                'adapter' => 'sqlite',
                // 'name' => ':memory:',
                'name' => 'db/db.testing',
                'suffix' => 'sqlite'
            ],
        ],
        'version_order' => 'creation'
    ];
