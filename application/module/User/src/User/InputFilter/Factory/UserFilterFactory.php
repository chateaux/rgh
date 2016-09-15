<?php
namespace User\InputFilter\Factory;

use Doctrine\ORM\EntityManager;
use User\Entity\User;
use User\InputFilter\UserFilter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserFilterFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $objectManager = $serviceLocator->getServiceLocator()->get(EntityManager::class);

        return new UserFilter(
            $objectManager,
            $objectManager->getRepository(User::class)
        );
    }
}
