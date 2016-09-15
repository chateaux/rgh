<?php
namespace Application\Library\Session;

use Application\Library\Settings\ApplicationSettings;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CookieServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new CookieService(
            $serviceLocator->get(ApplicationSettings::class)
        );
    }
}
