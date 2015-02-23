<?php

namespace Wishters\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Relation
 *
 * @ORM\Table(name="relation")
 * @ORM\Entity(repositoryClass="Wishters\FrontBundle\Entity\RelationRepository")
 */
class Relation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Wishters\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="follower_id", referencedColumnName="id")
     */
    private $follower;

    /**
     * @ORM\ManyToOne(targetEntity="Wishters\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="followed_id", referencedColumnName="id")
     */
    private $followed;


    public function __construct()
    {
        $this->date = new \DateTime();
    }


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
     * Set date
     *
     * @param \DateTime $date
     * @return Relation
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set follower
     *
     * @param \Wishters\UserBundle\Entity\User $follower
     * @return Relation
     */
    public function setFollower(\Wishters\UserBundle\Entity\User $follower = null)
    {
        $this->follower = $follower;

        return $this;
    }

    /**
     * Get follower
     *
     * @return \Wishters\UserBundle\Entity\User 
     */
    public function getFollower()
    {
        return $this->follower;
    }

    /**
     * Set followed
     *
     * @param \Wishters\UserBundle\Entity\User $followed
     * @return Relation
     */
    public function setFollowed(\Wishters\UserBundle\Entity\User $followed = null)
    {
        $this->followed = $followed;

        return $this;
    }

    /**
     * Get followed
     *
     * @return \Wishters\UserBundle\Entity\User 
     */
    public function getFollowed()
    {
        return $this->followed;
    }
}
