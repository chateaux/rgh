<?php
namespace User\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Rbac\Role\HierarchicalRoleInterface;
use ZfcRbac\Permission\PermissionInterface;

/**
 * @ORM\Entity(repositoryClass="HierarchicalRoleRepository")
 * @ORM\Table(name="rbu_roles")
 */
class HierarchicalRole implements HierarchicalRoleInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, length=48, nullable=true)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="User\Entity\HierarchicalRole")
     * @ORM\JoinTable(
     *     name="rbu_roles_hierarchy",
     *     joinColumns={@ORM\JoinColumn(name="hierarchical_role_source", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="hierarchical_role_target", referencedColumnName="id")}
     * )
     */
    private $children;

    /**
     * @var PermissionInterface[]|\Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="User\Entity\Permission", indexBy="name", fetch="EAGER")
     * @ORM\JoinTable(
     *     name="rbu_roles_permissions",
     *     joinColumns={@ORM\JoinColumn(name="hierarchical_role_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="permission_id", referencedColumnName="id")}
     * )
     */
    private $permissions;

    /**
     * Init the Doctrine collection
     */
    public function __construct()
    {
        $this->children    = new ArrayCollection();
        $this->permissions = new ArrayCollection();
    }

    /**
     * Get the role identifier
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the role name
     *
     * @param  string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * Get the role name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function addChild(HierarchicalRoleInterface $child)
    {
        $this->children[] = $child;
    }

    /**
     * {@inheritDoc}
     */
    public function addPermission($permission)
    {
        if (is_string($permission)) {
            $permission = new Permission($permission);
        }

        $this->permissions[(string) $permission] = $permission;
    }

    /**
     * {@inheritDoc}
     */
    public function hasPermission($permission)
    {
        // This can be a performance problem if your role has a lot of permissions. Please refer
        // to the cookbook to an elegant way to solve this issue

        return isset($this->permissions[(string) $permission]);
    }

    /**
     * {@inheritDoc}
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * {@inheritDoc}
     */
    public function hasChildren()
    {
        return !$this->children->isEmpty();
    }
}
