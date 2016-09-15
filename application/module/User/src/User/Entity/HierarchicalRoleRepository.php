<?php
namespace User\Entity;

use Doctrine\ORM\EntityRepository;

class HierarchicalRoleRepository extends EntityRepository
{
    public function getAccessibleRoles()
    {
        return $this->findAll();
    }
}
