<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\BaseEntity;

/**
 * Cup
 *
 * @ORM\Table(name="player")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlayerRepository")
 */
class Player extends BaseEntity
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=140)
     * @Assert\NotBlank(message="The name should not be blank.")
     * @Assert\Length(max=140, maxMessage="The Message can not be longer than 140 chars.")
     * @Assert\Regex("/[a-z]+/")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Result", mappedBy="team1player1")
     */
    private $player1results;

    /**
     * @ORM\OneToMany(targetEntity="Result", mappedBy="team1player2")
     */
    private $player2results;

    /**
     * @ORM\OneToMany(targetEntity="Result", mappedBy="team2player1")
     */
    private $player3results;

    /**
     * @ORM\OneToMany(targetEntity="Result", mappedBy="team2player2")
     */
    private $player4results;

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
     * Set name
     *
     * @param string $name
     *
     * @return Player
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->player1results = new \Doctrine\Common\Collections\ArrayCollection();
        $this->player2results = new \Doctrine\Common\Collections\ArrayCollection();
        $this->player3results = new \Doctrine\Common\Collections\ArrayCollection();
        $this->player4results = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add player1result
     *
     * @param \AppBundle\Entity\Result $player1result
     *
     * @return Player
     */
    public function addPlayer1result(\AppBundle\Entity\Result $player1result)
    {
        $this->player1results[] = $player1result;

        return $this;
    }

    /**
     * Remove player1result
     *
     * @param \AppBundle\Entity\Result $player1result
     */
    public function removePlayer1result(\AppBundle\Entity\Result $player1result)
    {
        $this->player1results->removeElement($player1result);
    }

    /**
     * Get player1results
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayer1results()
    {
        return $this->player1results;
    }

    /**
     * Add player2result
     *
     * @param \AppBundle\Entity\Result $player2result
     *
     * @return Player
     */
    public function addPlayer2result(\AppBundle\Entity\Result $player2result)
    {
        $this->player2results[] = $player2result;

        return $this;
    }

    /**
     * Remove player2result
     *
     * @param \AppBundle\Entity\Result $player2result
     */
    public function removePlayer2result(\AppBundle\Entity\Result $player2result)
    {
        $this->player2results->removeElement($player2result);
    }

    /**
     * Get player2results
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayer2results()
    {
        return $this->player2results;
    }

    /**
     * Add player3result
     *
     * @param \AppBundle\Entity\Result $player3result
     *
     * @return Player
     */
    public function addPlayer3result(\AppBundle\Entity\Result $player3result)
    {
        $this->player3results[] = $player3result;

        return $this;
    }

    /**
     * Remove player3result
     *
     * @param \AppBundle\Entity\Result $player3result
     */
    public function removePlayer3result(\AppBundle\Entity\Result $player3result)
    {
        $this->player3results->removeElement($player3result);
    }

    /**
     * Get player3results
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayer3results()
    {
        return $this->player3results;
    }

    /**
     * Add player4result
     *
     * @param \AppBundle\Entity\Result $player4result
     *
     * @return Player
     */
    public function addPlayer4result(\AppBundle\Entity\Result $player4result)
    {
        $this->player4results[] = $player4result;

        return $this;
    }

    /**
     * Remove player4result
     *
     * @param \AppBundle\Entity\Result $player4result
     */
    public function removePlayer4result(\AppBundle\Entity\Result $player4result)
    {
        $this->player4results->removeElement($player4result);
    }

    /**
     * Get player4results
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayer4results()
    {
        return $this->player4results;
    }
}
