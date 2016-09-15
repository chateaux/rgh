<?php
return [
    'toolbox-settings' => [
        'from_email'        => 'support@republicofgoodhope.org',
        'no_reply_email'    => 'no-reply@republicofgoodhope.org',
        'app_name'          => 'Republic of Good Hope',
        'support_desk'      => 'http://helpdesk.cinsadebt.com',
        'support_email'     => 'support@republicofgoodhope.org',
        'default_currency'  => 'EUR',
        'charge_vat'        => false,
        'vat_rate'          => 14,
        'cookie_domain'     => 'republicofgoodhope.org',
        'application_status' => [
            'is_live' => true,
            'message' => 'We are busy updating the database - the site will be down for 20m'
        ]
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
