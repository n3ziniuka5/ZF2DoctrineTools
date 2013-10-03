<?php
return [
    'service_manager' => [
        'invokables' => [
            'ZF2DoctrineTools\Service\CacheService'    => 'ZF2DoctrineTools\Service\CacheService',
        ],
        'initializers' => [
            'ZF2DoctrineTools\Initializer\ServiceInitializer'
        ]
    ],
    'controllers' => [
        'initializers' => [
            'ZF2DoctrineTools\Initializer\ControllerInitializer'
        ]
    ],
    'view_helpers' => [
        'initializers' => [
            'ZF2DoctrineTools\Initializer\ViewHelperInitializer'
        ]
    ],
];