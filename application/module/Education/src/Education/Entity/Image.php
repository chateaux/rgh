<?php
namespace Education\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="image")
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $state;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $size;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $width;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $height;

    /**
     * @ORM\ManyToOne(targetEntity="Education\Entity\Module", inversedBy="image")
     * @ORM\JoinColumn(name="module_id", referencedColumnName="id")
     */
    private $module;

    /**
     * @ORM\ManyToOne(targetEntity="Education\Entity\Test", inversedBy="image")
     * @ORM\JoinColumn(name="test_id", referencedColumnName="id")
     */
    private $test;

    /**
     * @ORM\ManyToOne(targetEntity="Education\Entity\Question", inversedBy="image")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    private $question;
}