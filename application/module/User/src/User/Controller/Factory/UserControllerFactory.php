<?php
namespace User\Controller\Factory;

use User\Controller\UserController;
use User\Service\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realSl = $serviceLocator->getServiceLocator();

        return new UserController(
            $realSl->get(AuthenticationService::class)
        );
    }
}
