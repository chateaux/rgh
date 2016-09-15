<?php
namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 */
class Country
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=2, nullable=true, name="code2")
     */
    private $code2;

    /**
     * @ORM\Column(type="string", length=3, nullable=true, name="code3")
     */
    private $code3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="name")
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true, name="gmt")
     */
    private $gmt;

    /**
     * @ORM\OneToMany(targetEntity="User\Entity\User", mappedBy="country")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getCode2()
    {
        return $this->code2;
    }

    /**
     * @param mixed $code2
     */
    public function setCode2($code2)
    {
        $this->code2 = $code2;
    }

    /**
     * @return mixed
     */
    public function getCode3()
    {
        return $this->code3;
    }

    /**
     * @param mixed $code3
     */
    public function setCode3($code3)
    {
        $this->code3 = $code3;
    }

    /**
     * @return mixed
     */
    public function getGmt()
    {
        return $this->gmt;
    }

    /**
     * @param mixed $gmt
     */
    public function setGmt($gmt)
    {
        $this->gmt = $gmt;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}
