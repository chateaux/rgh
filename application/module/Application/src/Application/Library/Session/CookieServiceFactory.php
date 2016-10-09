<?php
namespace Application\Library\Session;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CookieServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $settings = $serviceLocator->get('Config');
        $settings = (isset($settings['app-settings'])) ? $settings['app-settings'] : [];

        return new CookieService(
            $settings
        );
    }
}
