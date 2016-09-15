<?php
namespace Application\InputFilter\Factory;

use Application\InputFilter\RegisterFilter;
use Doctrine\ORM\EntityManager;
use User\Entity\User;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RegisterFilterFactory implements FactoryInterface
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

        return new RegisterFilter(
            $objectManager,
            $objectManager->getRepository(User::class)
        );
    }
}
