<?php
namespace Education\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Module
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $created;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $modified;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $privilage_id;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $pointsRequire;

    /**
     * @ORM\OneToMany(targetEntity="Education\Entity\Image", mappedBy="module")
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="Education\Entity\Material", mappedBy="module")
     */
    private $material;

    /**
     * @ORM\OneToMany(targetEntity="Education\Entity\Test", mappedBy="module")
     */
    private $test;

    /**
     * 
     * 
     */
    private $privilage;
}
