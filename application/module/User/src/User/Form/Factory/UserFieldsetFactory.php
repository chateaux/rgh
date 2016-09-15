<?php
namespace User\Form\Factory;

use User\Entity\User;
use User\Form\UserFieldset;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserFieldsetFactory implements FactoryInterface
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

        return new UserFieldset(
            $realSl->get('Doctrine\ORM\EntityManager'),
            new User()
        );
    }
}
