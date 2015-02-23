<?php

namespace Wishters\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Annonce
 *
 * @ORM\Table(name="annonce")
 * @ORM\Entity(repositoryClass="Wishters\FrontBundle\Entity\AnnonceRepository")
 */
class Annonce
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
     * @var string
     * @Assert\Regex("/^\w+/")
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=true,
     *     message="Votre prix ne peut être qu'en chiffre"
     * )
     *
     * @ORM\Column(name="price", type="string", length=10)
     */
    private $price;

    /**
     * @var string
     * @Assert\Regex(
     *     pattern="/^\w+$/",
     *     match=true,
     *     message="Uniquement des chiffres ou lettres"
     * )
     * @ORM\Column(name="hashtag", type="string", length=50)
     */
    private $hashtag;

    /**
     * @var boolean
     *
     * @ORM\Column(name="urgent", type="boolean")
     */
    private $urgent;

    /**
     * @var boolean
     *
     * @ORM\Column(name="negoce", type="boolean")
     */
    private $negoce;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="Wishters\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Wishters\FrontBundle\Entity\Region")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    private $region;

    /**
     * @ORM\OneToOne(targetEntity="Wishters\FrontBundle\Entity\AnnoncePicture", cascade={"persist"})
     * @Assert\Valid()
     */
    private $picture;

    public function __construct()
    {
        $this->date   = new \DateTime();
        $this->urgent = false;
        $this->negoce = false;
        $this->price  = '...';
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
     * @return Annonce
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
     * Set content
     *
     * @param string $content
     * @return Annonce
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Annonce
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set hastag
     *
     * @param string $hastag
     * @return Annonce
     */
    public function setHashtag($hashtag)
    {
        $this->hashtag = $hashtag;

        return $this;
    }

    /**
     * Get hastag
     *
     * @return string 
     */
    public function getHashtag()
    {
        return $this->hashtag;
    }

    /**
     * Set urgent
     *
     * @param boolean $urgent
     * @return Annonce
     */
    public function setUrgent($urgent)
    {
        $this->urgent = $urgent;

        return $this;
    }

    /**
     * Get urgent
     *
     * @return boolean 
     */
    public function getUrgent()
    {
        return $this->urgent;
    }

    /**
     * Set negoce
     *
     * @param boolean $negoce
     * @return Annonce
     */
    public function setNegoce($negoce)
    {
        $this->negoce = $negoce;

        return $this;
    }

    /**
     * Get negoce
     *
     * @return boolean 
     */
    public function getNegoce()
    {
        return $this->negoce;
    }

    /**
     * Set user
     *
     * @param \Wishters\UserBundle\Entity\User $user
     * @return Blog
     */
    public function setUser(\Wishters\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Wishters\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Annonce
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set region
     *
     * @param \Wishters\FrontBundle\Entity\Region $region
     * @return Annonce
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
     * Set picture
     *
     * @param \Wishters\FrontBundle\Entity\AnnoncePicture $picture
     * @return Annonce
     */
    public function setPicture(\Wishters\FrontBundle\Entity\AnnoncePicture $picture = null)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return \Wishters\FrontBundle\Entity\AnnoncePicture 
     */
    public function getPicture()
    {
        return $this->picture;
    }
}
