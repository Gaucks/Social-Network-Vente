<?php

namespace Wishters\FrontBundle\Twig;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class TwigExtension extends \Twig_Extension {

    private $em;
    private $tokenStorage;

    public function __construct(EntityManager $em, TokenStorage $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;

        if (is_object($this->tokenStorage->getToken())) {
            $this->user = $this->tokenStorage->getToken()->getUser();
        }

        // Initialisation des répertoires
        $this->userRepository = $this->em->getRepository('WishtersUserBundle:User');
        $this->relationRepository = $this->em->getRepository('WishtersFrontBundle:Relation');
    }

    public function getFilters()
    {
        return array(
            'validate_option' => new \Twig_Filter_Method($this, 'validateOption'),
            'check_diese'     => new \Twig_Filter_Method($this, 'checkDiese'),
            'is_follow'       => new \Twig_Filter_Method($this, 'isFollow'),
            'socialNetworkUrl'=> new \Twig_Filter_Method($this, 'socialNetworkUrl'),
        );
    }

    public function validateOption($validationInformation)
    {
        return $validationInformation ? 'active' : 'inactive' ;
    }

    public function checkDiese($validationInformation)
    {
        return $this->dieseMatch($validationInformation);
    }

    private function dieseMatch($validationInformation)
    {
        if(preg_match('#^\##', $validationInformation)){
            return $validationInformation;
        }
        else{
            return '#'.$validationInformation;
        }
    }

    public function isFollow($validationInformation)
    {
        $followed = $this->userRepository->find($validationInformation);

        $relation = $this->relationRepository->findRelation($this->user, $followed);

        if($relation){
            return true;
        }

        return false;
    }

    public function socialNetworkUrl($validationInformation)
    {
        if($validationInformation != null){
            return $validationInformation;
        }else{
            return '#';
        }
    }

    public function getName()
    {
        return 'wishters_twig_extension';
    }

}