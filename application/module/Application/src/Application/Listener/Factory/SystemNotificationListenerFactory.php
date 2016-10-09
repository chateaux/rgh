<?php
namespace Application\Listener\Factory;

use Application\Library\Mail\Service\MailService;
use Application\Listener\SystemNotificationListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SystemNotificationListenerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $settings = $serviceLocator->get('Config');
        $settings = (isset($settings['app-settings'])) ? $settings['app-settings'] : [];

        return new SystemNotificationListener(
            $serviceLocator->get(MailService::class),
            $settings,
            $serviceLocator->get('Zend\View\Renderer\RendererInterface')
        );
    }
}
