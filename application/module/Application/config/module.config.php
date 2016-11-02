<?php
namespace Application;

use Application\Controller\Factory\IndexControllerFactory;
use Application\Controller\Factory\LoginRegisterControllerFactory;
use Application\Controller\IndexController;
use Application\Controller\LoginRegisterController;
use Application\Controller\Plugin\RedirectPlugin;
use Application\Form\Factory\RegisterFormFactory;
use Application\Form\Factory\VerifyFormFactory;
use Application\Form\LoginForm;
use Application\Form\RegisterForm;
use Application\Form\VerifyForm;
use Application\InputFilter\Factory\RegisterFilterFactory;
use Application\InputFilter\RegisterFilter;
use Application\InputFilter\VerifyFilter;
use Application\Library\Mail\Options\ModuleOptions;
use Application\Library\Mail\Options\ModuleOptionsFactory;
use Application\Library\Mail\Service\MailService;
use Application\Library\Mail\Service\MailServiceFactory;
use Application\Library\Session\CookieService;
use Application\Library\Session\CookieServiceFactory;
use Application\Listener\Factory\SystemNotificationListenerFactory;
use Application\Listener\SystemNotificationListener;
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
            'verify' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/verify',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'verify',
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
            'faq' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/faq',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'faq',
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
            'confirm-email' => [
                'type' => 'segment',
                'options' => [
                    'route'    => '/confirm-email/:activation_code',
                    'defaults' => [
                        'controller' => LoginRegisterController::class,
                        'action'     => 'confirm-email',
                    ],
                ],
            ],
            'terms' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/terms',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'terms',
                    ],
                ],
            ],
            'contract-pdf' => [
                'type' => 'segment',
                'options' => [
                    'route'    => '/contract-pdf/:variable',
                    'constraints' => [
                        'constraints' => '[upload,download]'
                    ],
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'contract-pdf',
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
            SystemNotificationListener::class => SystemNotificationListenerFactory::class,
            CookieService::class => CookieServiceFactory::class,
            MailService::class => MailServiceFactory::class,
            ModuleOptions::class => ModuleOptionsFactory::class
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
            VerifyForm::class => VerifyFormFactory::class,
        ]
    ],
    'input_filters'      => [
        'invokables' => [
            'VerifyFilter' => VerifyFilter::class,
        ],
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
            //BASE EMAIL LAYOUT
            'email/layout' => __DIR__ . '/../view/email/layout/layout.phtml',
            'email/layout/text' => __DIR__ . '/../view/email/layout/layout_text.phtml',
            //LAYOUTS PULLED INTO BASE
            'email/confirm' => __DIR__ . '/../view/email/confirm.phtml',
            'email/confirm/text' => __DIR__ . '/../view/email/confirm_text.phtml',
            //PDF TEMPLATE
            'pdf/agreement' => __DIR__ . '/../view/pdf/pdf_agreement.phtml',
            'pdf/verify-automobile' => __DIR__ . '/../view/pdf/pdf_verify-automobile.phtml',
            'pdf/verify-identity' => __DIR__ . '/../view/pdf/pdf_verify-identity.phtml',
            //PUBLIC PAGES
            'application/index/home' => __DIR__ . '/../view/public/home.phtml',
            'application/index/verify' => __DIR__ . '/../view/public/verify.phtml',
            'application/index/identity' => __DIR__ . '/../view/public/identity.phtml',
            'application/index/passport' => __DIR__ . '/../view/public/passport.phtml',
            'application/index/birth' => __DIR__ . '/../view/public/birth.phtml',
            'application/index/marriage' => __DIR__ . '/../view/public/marriage.phtml',
            'application/index/company' => __DIR__ . '/../view/public/company.phtml',
            'application/index/money' => __DIR__ . '/../view/public/money.phtml',
            'application/index/terms' => __DIR__ . '/../view/public/terms.phtml',
            'application/index/conveyance' => __DIR__ . '/../view/public/conveyance.phtml',
            'application/index/reporting' => __DIR__ . '/../view/public/reporting.phtml',
            'application/index/faq' => __DIR__ . '/../view/public/faq.phtml',
            'application/login-register/login' => __DIR__ . '/../view/login_register/login.phtml',
            'application/login-register/register' => __DIR__ . '/../view/login_register/register.phtml',
            'application/login-register/register-landing' => __DIR__ . '/../view/login_register/register-landing.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
