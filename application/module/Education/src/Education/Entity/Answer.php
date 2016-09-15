<?php
namespace Education\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Answer
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
    private $answer;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $isCorrect;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $points;

    /**
     * @ORM\ManyToOne(targetEntity="Education\Entity\Question", inversedBy="answer")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    private $question;
}