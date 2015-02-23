<?php

namespace Wishters\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SpaceBoxController extends Controller
{
    public function indexAction(Request $request)
    {
        $paginator = $this->get('knp_paginator');
        $blogManager = $this->get('blog_manager');
        $annonceManager  = $this->get('annonce_manager');
        $relationManager = $this->get('relation_manager');

        $relationToPropose = $relationManager->proposeSubHeaderRelation();

        $countAnnonce = $annonceManager->CountUserAnnonce($this->getUser());
        $propose  = $annonceManager->findAnnonceToPropose($this->getUser()->getRegion());

        $blog = $paginator->paginate($blogManager->mergeSpaceBoxActivity(),$request->query->get('page', 1)/*page number*/, 10/*limit per page*/);


        return $this->render('@WishtersFront/SpaceBox/blog.html.twig',array(
            'messages'      => $blog,
            'countAnnonce'  => $countAnnonce,
            'propose'       => $propose,
            'relationToPropose' => $relationToPropose
        ));
    }

}
