<?php
namespace User\Controller\Plugin\Factory;

use User\Controller\Plugin\UserPlugin;
use User\Service\AuthenticationService;
use User\Service\RoleService;
use User\Service\UserService;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class UserPluginFactory implements FactoryInterface

{
    public function createService(ServiceLocatorInterface $sl)
    {
        $realSL = $sl->getServiceLocator();

        return new UserPlugin(
            $realSL->get(AuthenticationService::class),
            $realSL->get(UserService::class),
            $realSL->get(RoleService::class)
        );
    }
}