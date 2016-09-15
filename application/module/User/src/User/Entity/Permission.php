<?php
namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use ZfcRbac\Permission\PermissionInterface;

/**
 * Class Permission
 * @package User\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="rbu_permissions")
 */
class Permission implements PermissionInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id")
     *
     * @var int
     * @access protected
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true, nullable=false, name="name")
     *
     * @var string
     * @access protected
     */
    protected $name;

    /**
     *
     */
    private $description;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }



    /**
     * Get the permission name
     *
     * You really must return the name of the permission as internally, the casting to string is used
     * as an optimization to avoid type checkings
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
