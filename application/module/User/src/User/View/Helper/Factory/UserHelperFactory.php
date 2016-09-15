<?php
namespace User\View\Helper\Factory;

use User\Service\AuthenticationService;
use User\View\Helper\UserHelper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

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
