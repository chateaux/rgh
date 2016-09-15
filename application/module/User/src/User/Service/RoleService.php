<?php
namespace User\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use User\Entity\HierarchicalRole;
use Zend\Paginator\Paginator;
use DoctrineModule\Paginator\Adapter\Selectable as SelectableAdapter;

class RoleService
{
    /**
     * @var
     */
    protected $rolesRepository;

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $objectManager;

    public function __construct(
        ObjectManager    $objectManager,
        ObjectRepository $rolesRepository

    )
    {
        $this->rolesRepository    = $rolesRepository;
        $this->objectManager      = $objectManager;
    }

    /**
     * @param $id
     * @return mixed|object
     */
    public function find($id)
    {
        return $this->rolesRepository->find($id);
    }

    public function findOneByName($name)
    {
        return $this->rolesRepository->findOneByName($name);
    }

    /**
     * @param HierarchicalRole $roleObject
     * @return bool|mixed
     */
    public function update(HierarchicalRole $roleObject) {
        try {
            $this->objectManager->persist($roleObject);
            $this->objectManager->flush();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param HierarchicalRole $rolesObject
     * @return bool|mixed|HierarchicalRole
     */
    public function add(HierarchicalRole $rolesObject)
    {
        try {
            $this->objectManager->persist($rolesObject);
            $this->objectManager->flush();
        } catch (\Exception $e) {
            return false;
        }

        return $rolesObject;
    }

    /**
     * @param $page
     * @param $count
     * @return mixed|Paginator
     */
    public function getPaged($page, $count) {
        $adapter = new SelectableAdapter($this->rolesRepository);
        $paginator = new Paginator($adapter);
        return $paginator->setCurrentPageNumber( (int) $page )->setItemCountPerPage( (int) $count );
    }

    public function delete(HierarchicalRole $myObject)
    {

        //@TODO While this will fail due to foreign keys, would be nice to have a check in place

        //Guest Role must not be deleted unless we want this app to croak

        if ( in_array( $myObject->getName(), array('guest','admin') ) ) {
            return "That is a protected role.";
        }

        try {
            $this->objectManager->remove($myObject);
            $this->objectManager->flush();
        } catch(\Exception $e) {
            return "There was an exception, please updated all users associated to this role and try again.";
        }

        return true;
    }

}