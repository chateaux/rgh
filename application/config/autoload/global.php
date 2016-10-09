<?php
return [
    'app-settings' => [
        'from_email'        => 'support@republicofgoodhope.org',
        'no_reply_email'    => 'no-reply@republicofgoodhope.org',
        'support_desk'      => 'http://support.republicofgoodhope.org',
        'cookie_domain'     => 'republicofgoodhope.org',
    ],
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' =>'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => [
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'user'     => 'user',
                    'password' => 'password',
                    'dbname'   => 'database',
                    'driverOptions' => [
                        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET sql_mode=(SELECT REPLACE(@@sql_mode,"ONLY_FULL_GROUP_BY",""));',
                    ],
                ],
                'doctrine_type_mappings' => [
                    'uuid_binary' => 'binary',
                ],
            ],
        ],
        'eventmanager' => [
            'orm_default' => [
                'subscribers' => [
                    'Gedmo\Timestampable\TimestampableListener',
                ],
            ],
        ],
        'configuration' => [
            'orm_default' => [
                'naming_strategy' => 'UnderscoreNamingStrategy',
                'generate_proxies' => false,
                'types' => [
                    'uuid_binary' => 'Ramsey\Uuid\Doctrine\UuidBinaryType',
                ],
            ],
        ],
        'authentication' => [
            'orm_default' => [
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'User\Entity\User',
                'identity_property' => 'email',
                'credential_property' => 'password',
                'credential_callable' => function (\User\Entity\User $user, $passwordGiven) {
                    $hashedPassword  = $user->getPassword();
                    $passwordService = new \User\Service\PasswordService();
                    return $passwordService->verify($passwordGiven, $hashedPassword);
                },
            ],
        ],
    ],
];
