<?php
namespace Education;

return [

    'doctrine'           => [
        'driver' => [
            'education_driver'  => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Education/Entity'
                ]
            ],
            'orm_default' => [
                'drivers' => [
                    'Education\Entity' => 'education_driver'
                ]
            ]
        ],
    ],
];
