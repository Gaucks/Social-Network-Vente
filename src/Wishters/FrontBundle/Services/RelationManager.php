<?php
/**
 * Created by PhpStorm.
 * User: Kris
 * Date: 22/02/15
 * Time: 08:41
 */

namespace Wishters\FrontBundle\Services;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class RelationManager {

    protected $entityManager;
    protected $tokenStorage;

    public function __construct(EntityManager $entityManager, TokenStorage $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage  = $tokenStorage;
        $this->repository   = $this->entityManager->getRepository('WishtersFrontBundle:Relation');
        $this->userRepository = $this->entityManager->getRepository('WishtersUserBundle:User');

        if(is_object($tokenStorage)){
            $this->user = $this->tokenStorage->getToken()->getUser();
        } else{
            $this->user = null;
        }
    }

    public function proposeSubHeaderRelation()
    {
        $relationListe = $this->repository->findBy(array('follower' => $this->user->getId()));

        if(!$relationListe){

            $userToPropose = $this->userRepository->getUserToPropose($this->user);

        }else{
            $userToPropose = $this->userRepository->getUserToPropose($this->user, $relationListe);
        }

        return $userToPropose;
    }



}