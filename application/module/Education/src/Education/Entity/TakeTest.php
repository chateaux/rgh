<?php
namespace Education\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class TakeTest
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateOfTest;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $score;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $startTime;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $endTime;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $countScore;

    /**
     * @ORM\OneToMany(targetEntity="Education\Entity\Test", mappedBy="takeTest")
     */
    private $tests;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User", inversedBy="takeTest")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;
}