<?php

return [
    /*
     * Formatter should be instance of Monolog\Formatter
     * For working with redis wrapper we need active redis configuration in database section
     */
    'app_tag' => 'app',

    'channels' => [
        'default' => ['main'],

        'main' => [
            'filename' => 'laravel.log',
            'handler' => \Majesko\Logger\Wrappers\RotatingFileWrapper::class,
            'target' => storage_path('logs/'),
            'formatter' => [
                'class' => \Monolog\Formatter\LineFormatter::class,
                'args' => [null, null, true, false]
            ],
            'log' => 'daily',
            'log_max_files' => config('app.log_max_files')
        ],
        /*'migration' => [
            'filename' => 'migration.log',
            'handler' => \Majesko\Logger\Wrappers\RotatingFileWrapper::class,
            'target' => storage_path('logs/migrations/'),
            'log_max_files' => config('app.log_max_files')
        ],*/
        /*'es' => [
            'filename' => 'es.log',
            'handler' => \Majesko\Logger\Wrappers\RotatingFileWrapper::class,
            'target' => storage_path('logs/es/'),
            'formatter' => [
                'class' => Monolog\Formatter\JsonFormatter::class,
                'args' => [],
            ],
            'log' => 'daily',
            'log_max_files' => 0
        ]*/
    ]
];
