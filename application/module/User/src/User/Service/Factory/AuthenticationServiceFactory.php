<?php
namespace User\Service\Factory;

use Doctrine\ORM\EntityManager;
use User\Entity\User;
use User\Service\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthenticationServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new AuthenticationService(
            $serviceLocator->get(EntityManager::class)->getRepository(User::class),
            $serviceLocator->get('application')->getEventManager(),
            $serviceLocator->get('doctrine.authenticationservice.orm_default')
        );
    }
}
