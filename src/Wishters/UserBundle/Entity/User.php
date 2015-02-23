<?php

namespace Wishters\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="Wishters\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Wishters\FrontBundle\Entity\Region")
     * @ORM\joinColumn(name="region_id", referencedColumnName="id")
     */
    protected $region;

    /**
     * @ORM\ManyToOne(targetEntity="Wishters\UserBundle\Entity\Avatar", cascade={"persist"})
     * @ORM\joinColumn(name="avatar_id", referencedColumnName="id")
     * @Assert\Valid()
     */
    protected $avatar;

    /**
     * @ORM\Column(name="theword", type="text", nullable=true)
     */
    protected $theword;

    /**
     * @ORM\Column(name="facebook", type="string", nullable=true)
     */
    protected $facebook;

    /**
     * @ORM\Column(name="googleplus", type="string", nullable=true)
     */
    protected $googleplus;

    /**
     * @ORM\Column(name="twitter", type="string", nullable=true)
     */
    protected $twitter;

    public function __construct()
    {
        parent::__construct();
        // your own logic
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
     * Set region
     *
     * @param \Wishters\FrontBundle\Entity\Region $region
     * @return User
     */
    public function setRegion(\Wishters\FrontBundle\Entity\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \Wishters\FrontBundle\Entity\Region 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set avatar
     *
     * @param \Wishters\UserBundle\Entity\Avatar $avatar
     * @return User
     */
    public function setAvatar(\Wishters\UserBundle\Entity\Avatar $avatar = null)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return \Wishters\UserBundle\Entity\Avatar 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set theword
     *
     * @param string $theword
     * @return User
     */
    public function setTheword($theword)
    {
        $this->theword = $theword;

        return $this;
    }

    /**
     * Get theword
     *
     * @return string 
     */
    public function getTheword()
    {
        return $this->theword;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     * @return User
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string 
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set googleplus
     *
     * @param string $googleplus
     * @return User
     */
    public function setGoogleplus($googleplus)
    {
        $this->googleplus = $googleplus;

        return $this;
    }

    /**
     * Get googleplus
     *
     * @return string 
     */
    public function getGoogleplus()
    {
        return $this->googleplus;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     * @return User
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string 
     */
    public function getTwitter()
    {
        return $this->twitter;
    }
}
