<?php

namespace Wishters\FrontBundle\Services;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class WishtersService {

    protected $em;
    protected $tokenStorage;
    protected $regionRepository;
    protected $user;

    public function __construct(EntityManager $em, TokenStorage $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->regionRepository = $this->em->getRepository('WishtersFrontBundle:Region');

        $this->user = $this->tokenStorage->getToken()->getUser();
        if (!is_object($this->user) || !$this->user instanceof UserInterface) {
            $this->user = null;
        }

    }

    public function getRegion($requestRegion)
    {

        if(!$requestRegion){ // Il n'y à pas de parametre on propose donc ' Toute la france '
            if(!$this->user){ // L'utisisateur est anonyme
                $region = $this->regionRepository->find(1);
            } // L'utilisateur est connecté
            else{
                $region = $this->regionRepository->find($this->user->getRegion());
            }
        } // Une région est renseigné
        else{

            $region = $this->regionRepository->findOneBy(array('slug' => $requestRegion));

            // Si la région soumise n'existe pas.
            if(!$region)
            {
                throw new NotFoundHttpException("Oups...Il doit y avoir une erreur sur cette page, désolé.");
            }
        }

        return $region;
    }

    public function getAllRegion()
    {
        return $this->regionRepository->findBy(array(), array('nom' => 'ASC'));
    }

}