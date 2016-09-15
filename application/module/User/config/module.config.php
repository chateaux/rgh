<?php
namespace User;

use User\Controller\Factory\UserControllerFactory;
use User\Controller\Plugin\Factory\UserPluginFactory;
use User\Controller\UserController;
use User\Form\Factory\UserFieldsetFactory;
use User\Form\UserFieldset;
use User\InputFilter\Factory\UserFilterFactory;
use User\InputFilter\UserFilter;
use User\Service\AuthenticationService;
use User\Service\Factory\AuthenticationServiceFactory;
use User\Service\Factory\RoleServiceFactory;
use User\Service\Factory\UserServiceFactory;
use User\Service\RoleService;
use User\Service\UserService;
use User\View\Helper\Factory\UserHelperFactory;
use Zend\Authentication\AuthenticationService as BaseAuthenticationService;

return [
    'form_elements'      => [
        'factories'  => [
            UserFieldset::class => UserFieldsetFactory::class,
        ]
    ],
    'input_filters'      => [
        'factories' => [
            UserFilter::class => UserFilterFactory::class,
        ]
    ],
    'service_manager' => [
        'factories' => [
            UserService::class => UserServiceFactory::class,
            BaseAuthenticationService::class => AuthenticationServiceFactory::class,
            AuthenticationService::class => AuthenticationServiceFactory::class,
            RoleService::class => RoleServiceFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            UserController::class => UserControllerFactory::class,
        ],
    ],
    'controller_plugins' => [
        'factories' => [
            'UserPlugin' => UserPluginFactory::class,
        ]
    ],
    'view_helpers'  => [
        'factories' => [
            'UserHelper' => UserHelperFactory::class,
        ],
    ],
    'router'    => [
        'routes'    => [
            'user' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/user',
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'account' => [
                        'type'    => 'Literal',
                        'options' => [
                            'route'       => '/account',
                            'defaults' => [
                                'controller' => UserController::class,
                                'action'     => 'account'
                            ]
                        ],
                    ],
                ]
            ]
        ]
    ],
    'view_manager' => [
        'template_map' => [
            'user/user/account' => __DIR__ . '/../view/user/account.phtml',
        ],
    ],
    'doctrine'           => [
        'driver' => [
            'user_driver'  => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/User/Entity'
                ]
            ],
            'orm_default' => [
                'drivers' => [
                    'User\Entity' => 'user_driver'
                ]
            ]
        ],
    ],
];
