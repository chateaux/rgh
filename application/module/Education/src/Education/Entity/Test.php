<?php
namespace Education\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Test
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
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $isActive;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $countScore;

    /**
     * @ORM\OneToMany(targetEntity="Education\Entity\Image", mappedBy="test")
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="Education\Entity\Material", mappedBy="test")
     */
    private $material;

    /**
     * @ORM\OneToMany(targetEntity="Education\Entity\Question", mappedBy="test")
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity="Education\Entity\Module", inversedBy="test")
     * @ORM\JoinColumn(name="module_id", referencedColumnName="id", nullable=false)
     */
    private $module;

    /**
     * @ORM\ManyToOne(targetEntity="Education\Entity\TakeTest", inversedBy="tests")
     * @ORM\JoinColumn(name="take_test_id", referencedColumnName="id", nullable=false)
     */
    private $takeTest;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User", inversedBy="test")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $author;
}