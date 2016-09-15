<?php
namespace Education\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Question
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(nullable=false)
     */
    private $question;

    /**
     * @ORM\OneToMany(targetEntity="Education\Entity\Image", mappedBy="question")
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="Education\Entity\Answer", mappedBy="question")
     */
    private $answer;

    /**
     * @ORM\ManyToOne(targetEntity="Education\Entity\Test", inversedBy="question")
     * @ORM\JoinColumn(name="test_id", referencedColumnName="id")
     */
    private $test;
}
