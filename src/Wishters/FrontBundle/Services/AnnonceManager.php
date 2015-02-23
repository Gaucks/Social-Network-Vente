<?php

namespace Wishters\FrontBundle\Services;


use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class AnnonceManager {

    protected $em;
    protected $repository;
    protected $tokenStorage;

    public function __construct(EntityManager $em, TokenStorage $tokenStorage)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('WishtersFrontBundle:Annonce');
        $this->tokenStorage = $tokenStorage;

        $this->user = $this->tokenStorage->getToken()->getUser();
        if(!is_object($this->user) || !$this->user instanceof UserInterface)
        {
            $this->user = null;
        }
    }

    public function countUserAnnonce($user)
    {
        return $this->repository->countUserAnnonce($user);
    }

    public function finRegionByAnnonce($id)
    {
        $annonce = $this->repository->find($id);

        if(!$annonce->getRegion()){
            throw new NotFoundHttpException("Oups...Il doit y avoir une erreur sur cette page, désolé.");
        }
        return $annonce->getRegion();
    }

    public function findAnnonceByRegion($requestRegion)
    {
        if($requestRegion->getSlug() != 'toute-la-france'){
            return $this->repository->findBy(array('region' => $requestRegion),array('date' => 'DESC'));
        }
        return $this->repository->findBy(array(),array('date' => 'DESC'));
    }

    public function findAnnonceToPropose($region)
    {
        return $this->repository->getAnnonceToPropose($this->user, $region);
    }

    public function findAnnonceByHashtag($hashtag)
    {
        return $this->repository->findBy(array('hashtag' => $hashtag));
    }

    public function findTopHastags()
    {
        return $this->repository->findTopHastags();
    }

    public function removeAnnonce($annonce)
    {
        if($this->preRemoveControl($annonce)){
            $this->em->remove($annonce);
            $this->em->flush();

            return true;
        }

        return false;
    }

    private function preRemoveControl($annonce)
    {
        if($annonce->getUser() === $this->user){
            return true;
        }

        return false;
    }

    public function findLastFive($user)
    {
        return $this->repository->findBy(array('user' => $user), array('date' => 'DESC'), 4);
    }

}