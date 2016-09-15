<?php
namespace Application;

use Application\Controller\Factory\IndexControllerFactory;
use Application\Controller\Factory\LoginRegisterControllerFactory;
use Application\Controller\IndexController;
use Application\Controller\LoginRegisterController;
use Application\Controller\Plugin\RedirectPlugin;
use Application\Form\Factory\RegisterFormFactory;
use Application\Form\LoginForm;
use Application\Form\RegisterForm;
use Application\InputFilter\Factory\RegisterFilterFactory;
use Application\InputFilter\RegisterFilter;
use Application\Library\Session\CookieService;
use Application\Library\Session\CookieServiceFactory;
use Application\Library\Settings\ApplicationSettings;
use Application\Library\Settings\ApplicationSettingsFactory;
use Application\View\Helper\FlashMessengerHelper;
use Application\View\Helper\PageViewHelper;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'home',
                    ],
                ],
            ],
            'identity' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/identity',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'identity',
                    ],
                ],
            ],
            'passport' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/passport',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'passport',
                    ],
                ],
            ],
            'birth' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/birth',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'birth',
                    ],
                ],
            ],
            'marriage' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/marriage',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'marriage',
                    ],
                ],
            ],
            'company' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/company',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'company',
                    ],
                ],
            ],
            'money' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/money',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'money',
                    ],
                ],
            ],
            'conveyance' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/conveyance',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'conveyance',
                    ],
                ],
            ],
            'reporting' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/reporting',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'reporting',
                    ],
                ],
            ],
            'login' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/login',
                    'defaults' => [
                        'controller' => LoginRegisterController::class,
                        'action'     => 'login',
                    ],
                ],
            ],
            'register' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/register',
                    'defaults' => [
                        'controller' => LoginRegisterController::class,
                        'action'     => 'register',
                    ],
                ],
            ],
            'logout' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/logout',
                    'defaults' => [
                        'controller' => LoginRegisterController::class,
                        'action'     => 'logout',
                    ],
                ],
            ],
            'register-landing' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/register-landing',
                    'defaults' => [
                        'controller' => LoginRegisterController::class,
                        'action'     => 'register-landing',
                    ],
                ],
            ],
        ],
    ],
    'asset_manager' => [
        'caching' => [
            'default' => [
                'cache'     => 'FilePath',  // Apc, FilePath, FileSystem etc.
                'options' => [
                    'dir'   => 'public'
                ]
            ],
        ],
        'resolver_configs' => [
            'paths' => [
                __DIR__ . '/../assets',
            ]

        ],
    ],
    'view_helpers'  => [
        'invokables'    => [
            'PageViewHelper' => PageViewHelper::class,
            'FlashMessengerHelper'  => FlashMessengerHelper::class,
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'invokables' => [
            'UnderscoreNamingStrategy' => UnderscoreNamingStrategy::class,
        ],
        'factories' =>
        [
            CookieService::class => CookieServiceFactory::class,
            ApplicationSettings::class => ApplicationSettingsFactory::class
        ]
    ],
    'controllers' => [
        'factories' => [
            IndexController::class => IndexControllerFactory::class,
            LoginRegisterController::class => LoginRegisterControllerFactory::class,
        ],
    ],
    'controller_plugins' => [
        'invokables' => [
            'RedirectPlugin' => RedirectPlugin::class
        ]
    ],
    'form_elements'      => [
        'invokables' => [
            'LoginForm' => LoginForm::class,
        ],
        'factories'  => [
            RegisterForm::class => RegisterFormFactory::class,
        ]
    ],
    'input_filters'      => [
        'factories' => [
            RegisterFilter::class => RegisterFilterFactory::class,
        ]
    ],
    'view_helper_config' => [
        'flashmessenger' => [
            'message_open_format'      => '<div%s><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><ul><li>',
            'message_close_string'     => '</li></ul></div>',
            'message_separator_string' => '</li><li>'
        ]
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/exception',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout_layout.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
            'error/exception' => __DIR__ . '/../view/error/index.phtml',

            'application/index/home' => __DIR__ . '/../view/public/home.phtml',
            'application/index/identity' => __DIR__ . '/../view/public/identity.phtml',
            'application/index/passport' => __DIR__ . '/../view/public/passport.phtml',
            'application/index/birth' => __DIR__ . '/../view/public/birth.phtml',
            'application/index/marriage' => __DIR__ . '/../view/public/marriage.phtml',
            'application/index/company' => __DIR__ . '/../view/public/company.phtml',
            'application/index/money' => __DIR__ . '/../view/public/money.phtml',
            'application/index/conveyance' => __DIR__ . '/../view/public/conveyance.phtml',
            'application/index/reporting' => __DIR__ . '/../view/public/reporting.phtml',
            'application/login-register/login' => __DIR__ . '/../view/login_register/login.phtml',
            'application/login-register/register' => __DIR__ . '/../view/login_register/register.phtml',
            'application/login-register/register-landing' => __DIR__ . '/../view/login_register/register-landing.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
