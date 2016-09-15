<?php
namespace User\View\Helper\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use User\View\Helper\UserHelper;
use User\Service\AuthenticationService;

class UserHelperFactory implements FactoryInterface

{
    public function createService(ServiceLocatorInterface $sl)
    {
        $realSL = $sl->getServiceLocator();

        return new UserHelper(
            $realSL->get(AuthenticationService::class)
        );
    }
}