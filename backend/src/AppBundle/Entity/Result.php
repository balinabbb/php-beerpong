<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\BaseEntity;

/**
 * Cup
 *
 * @ORM\Table(name="result")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResultRepository")
 */
class Result extends BaseEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="team1score", type="integer")
     */
    private $team1score;

    /**
     * @var int
     *
     * @ORM\Column(name="team2score", type="integer")
     */
    private $team2score;

    /**
     * @ORM\ManyToOne(targetEntity="Cup", inversedBy="results")
     * @ORM\JoinColumn(name="cup", referencedColumnName="id")
     */
    private $cup;

    /**
     * @ORM\ManyToOne(targetEntity="Player", inversedBy="player1results")
     * @ORM\JoinColumn(name="team1player1", referencedColumnName="id")
     */
    private $team1player1;

    /**
     * @ORM\ManyToOne(targetEntity="Player", inversedBy="player2results")
     * @ORM\JoinColumn(name="team1player2", referencedColumnName="id")
     */
    private $team1player2;

    /**
     * @ORM\ManyToOne(targetEntity="Player", inversedBy="player3results")
     * @ORM\JoinColumn(name="team2player1", referencedColumnName="id")
     */
    private $team2player1;

    /**
     * @ORM\ManyToOne(targetEntity="Player", inversedBy="player4results")
     * @ORM\JoinColumn(name="team2player2", referencedColumnName="id")
     */
    private $team2player2;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cup
     *
     * @param \AppBundle\Entity\Cup $cup
     *
     * @return Result
     */
    public function setCup(\AppBundle\Entity\Cup $cup = null)
    {
        $this->cup = $cup;

        return $this;
    }

    /**
     * Get cup
     *
     * @return \AppBundle\Entity\Cup
     */
    public function getCup()
    {
        return $this->cup;
    }

    /**
     * Set team1player1
     *
     * @param \AppBundle\Entity\Player $team1player1
     *
     * @return Result
     */
    public function setTeam1player1(\AppBundle\Entity\Player $team1player1 = null)
    {
        $this->team1player1 = $team1player1;

        return $this;
    }

    /**
     * Get team1player1
     *
     * @return \AppBundle\Entity\Player
     */
    public function getTeam1player1()
    {
        return $this->team1player1;
    }

    /**
     * Set team1player2
     *
     * @param \AppBundle\Entity\Player $team1player2
     *
     * @return Result
     */
    public function setTeam1player2(\AppBundle\Entity\Player $team1player2 = null)
    {
        $this->team1player2 = $team1player2;

        return $this;
    }

    /**
     * Get team1player2
     *
     * @return \AppBundle\Entity\Player
     */
    public function getTeam1player2()
    {
        return $this->team1player2;
    }

    /**
     * Set team2player1
     *
     * @param \AppBundle\Entity\Player $team2player1
     *
     * @return Result
     */
    public function setTeam2player1(\AppBundle\Entity\Player $team2player1 = null)
    {
        $this->team2player1 = $team2player1;

        return $this;
    }

    /**
     * Get team2player1
     *
     * @return \AppBundle\Entity\Player
     */
    public function getTeam2player1()
    {
        return $this->team2player1;
    }

    /**
     * Set team2player2
     *
     * @param \AppBundle\Entity\Player $team2player2
     *
     * @return Result
     */
    public function setTeam2player2(\AppBundle\Entity\Player $team2player2 = null)
    {
        $this->team2player2 = $team2player2;

        return $this;
    }

    /**
     * Get team2player2
     *
     * @return \AppBundle\Entity\Player
     */
    public function getTeam2player2()
    {
        return $this->team2player2;
    }

    /**
     * Set team1score
     *
     * @param integer $team1score
     *
     * @return Result
     */
    public function setTeam1score($team1score)
    {
        $this->team1score = $team1score;

        return $this;
    }

    /**
     * Get team1score
     *
     * @return integer
     */
    public function getTeam1score()
    {
        return $this->team1score;
    }

    /**
     * Set team2score
     *
     * @param integer $team2score
     *
     * @return Result
     */
    public function setTeam2score($team2score)
    {
        $this->team2score = $team2score;

        return $this;
    }

    /**
     * Get team2score
     *
     * @return integer
     */
    public function getTeam2score()
    {
        return $this->team2score;
    }
}
