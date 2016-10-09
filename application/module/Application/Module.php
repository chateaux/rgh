<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Listener\SystemNotificationListener;
use User\Entity\User;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\Http\PhpEnvironment\Request;
use ZfcRbac\Service\AuthorizationService;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        if (!\Zend\Console\Console::isConsole()) {
            $t = $e->getTarget();
            $t->getEventManager()->attach(
                $t->getServiceManager()->get('ZfcRbac\View\Strategy\RedirectStrategy')
            );
        }

        $app = $e->getApplication();
        $em  = $app->getEventManager();
        $sm  = $app->getServiceManager();

        $em->attachAggregate($sm->get(SystemNotificationListener::class));

        if ($e->getRequest() instanceof Request) {
            $authService = $sm->get(AuthorizationService::class);
            $userObject = $authService->getIdentity();
            if (!$userObject instanceof User) {
                return;
            }
            if ($userObject->getIsEmailConfirmed() == 1) {
                return;
            }
            $em->attach(MvcEvent::EVENT_DISPATCH,
                function ($e) {
                    $route = $e->getRouteMatch();
                    if ($route->getMatchedRouteName() != 'register-landing') {
                        $controller = $e->getTarget();
                        $controller->plugin('redirect')->toUrl('/register-landing?');
                    }
                }
            );
        }

    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }
}
