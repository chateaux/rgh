<?php
namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 */
class UsStates
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=2, nullable=true, name="iso2")
     */
    private $code2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="name")
     */
    private $name;
}
