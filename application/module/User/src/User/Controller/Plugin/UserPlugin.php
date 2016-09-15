<?php
namespace User\Controller\Plugin;

use User\Entity\HierarchicalRole;
use User\Service\AuthenticationService;
use User\Service\RoleService;
use User\Service\UserService;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class UserPlugin extends AbstractPlugin
{
    private $roleService;
    private $authService;
    private $userService;


    public function __construct(
        AuthenticationService $authService,
        UserService $userService,
        RoleService $roleService
    ) {
        $this->authService = $authService;
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    /**
     * @param $roleName
     * @return mixed
     * @throws \Exception
     */
    public function getRoleObject($roleName)
    {
        $roleObject = $this->roleService->findOneByName($roleName);

        if (!$roleObject instanceof HierarchicalRole) {
            throw new \Exception("Unable to locate a role.");
        }

        return $roleObject;
    }
}
