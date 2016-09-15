<?php
namespace Application\Library\Session;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CookieHelperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sl)
    {
        $realSl = $sl->getServiceLocator();

        return new CookieHelper(
            $realSl->get(CookieService::class)
        );
    }
}
