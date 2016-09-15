<?php
namespace Application\Listener\Factory;

use Application\Listener\SystemNotificationListener;
use Toolbox\Library\Mail\Service\MailService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SystemNotificationListenerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $settings = $serviceLocator->get('Config');

        $settings = (isset($settings['settings'])) ? $settings['settings'] : [];

        return new SystemNotificationListener(
            $serviceLocator->get(MailService::class),
            $serviceLocator->get('Zend\View\Renderer\RendererInterface')
        );
    }
}
