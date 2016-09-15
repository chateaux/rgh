<?php
namespace User\Service\Factory;

use User\Entity\User;
use User\Service\UserService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $objectManager = $serviceLocator->get('Doctrine\ORM\EntityManager');

        return new UserService(
            $objectManager,
            $objectManager->getRepository(User::class),
            $serviceLocator->get('application')->getEventManager(),
            $serviceLocator->get('Zend\Authentication\AuthenticationService')
        );
    }
}
