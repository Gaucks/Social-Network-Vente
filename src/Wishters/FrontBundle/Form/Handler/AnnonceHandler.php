<?php

namespace Wishters\FrontBundle\Form\Handler;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Wishters\FrontBundle\Entity\Annonce;

/**
 * Class AnnonceHandler
 * @package Wishters\FrontBundle\Form\Handler
 */
class AnnonceHandler {

    protected $form;
    protected $request;
    protected $em;
    protected $tokenStorage;

    public function __construct(Form $form, Request $request, EntityManager $em, TokenStorage $tokenStorage)
    {
        $this->form = $form;
        $this->request = $request;
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->user = $this->tokenStorage->getToken()->getUser();

        // Controle si il s'agit d'une mise à jour
        // Et injecte l'objet annonce
        if($this->isUpdate()){
            $this->form->setData($request->get('annonce'));
        }
    }

    public function onProcess()
    {
        $this->form->handleRequest($this->request);

        if($this->form->isValid() && $this->request->isMethod('post')){

            $this->onSuccess();

            return true;
        }

        return false;
    }

    public function getForm()
    {
        return $this->form;
    }

    public function createView()
    {
        return $this->form->createView();
    }

    private function isUpdate(){
        if($this->request->attributes->get('_route') === 'wishters_front_annonce_edit'){
            return true;
        }

        return false;
    }

    protected function onSuccess()
    {
        $data = $this->form->getData();
        $data->setUser($this->user);
        $data->setRegion($this->user->getRegion());

        $this->em->persist($data);
        $this->em->flush();
    }

    public function onModalSend()
    {
        $formulaire = $this->request->getSession()->get('formulaire');

        if($formulaire) {
            $this->getForm()->submit($formulaire);

            return true;
        }

        return false;

    }

    public function removeSession()
    {
        return $this->request->getSession()->remove('formulaire');
    }


}