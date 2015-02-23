<?php

namespace Wishters\FrontBundle\Form\Handler;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class BlogHandler {

    protected $form;
    protected $request;
    protected $em;
    protected $tokenStorage;

    public function __construct(Form $form, Request $request, EntityManager $em, TokenStorage $tokenStorage )
    {
        $this->form = $form;
        $this->request = $request;
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->user = $this->tokenStorage->getToken()->getUser();
    }

    public function process()
    {
        $this->form->handleRequest($this->request);

        if($this->request->isMethod('POST') && $this->form->isValid()){
            $this->onSuccess();

            return true;
        }

        return false;
    }

    protected function onSuccess()
    {
        $data = $this->form->getData();
        $data->setUser($this->user);

        $this->em->persist($data);
        $this->em->flush();
    }

    protected function getForm()
    {
        return $this->form;
    }

    public function createView()
    {
        return $this->form->createView();
    }

}