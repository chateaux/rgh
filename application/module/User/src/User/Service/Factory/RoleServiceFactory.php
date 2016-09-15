<?php
namespace User\Service\Factory;

use User\Service\RoleService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RoleServiceFactory implements FactoryInterface
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
        $rolesRepository = $objectManager->getRepository('User\Entity\HierarchicalRole');

        return new RoleService(
            $objectManager,
            $rolesRepository
        );
    }
}
