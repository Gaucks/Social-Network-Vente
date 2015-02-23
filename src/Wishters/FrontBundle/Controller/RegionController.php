<?php

namespace Wishters\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegionController extends Controller
{
    public function showRegionAction(Request $request)
    {
        $wishtersService = $this->get('wishters_service');
        $annonceManager  = $this->get('annonce_manager');
        $paginator       = $this->get('knp_paginator');
        /**
         * On fait appel au service de wishters pour récupérer
         * l'objet Region()
         * et l'afficher le nom de la région dans le " subheader "
         * /show-region
         */
        $region         = $wishtersService->getRegion($request->get('region'));
        $regions        = $wishtersService->getAllRegion();
        $findAnnonces   = $annonceManager->findAnnonceByRegion($region);
        $propose        = $annonceManager->findAnnonceToPropose($region);

        $annonces       = $paginator->paginate($findAnnonces,$request->query->get('page', 1)/*page number*/, 10/*limit per page*/);


        return $this->render('@WishtersFront/Region/showRegion.html.twig', array('region' => $region,
            'regions'       => $regions,
            'annonces'      => $annonces,
            'propose'       => $propose,
            'countAnnonce'  => null,
            ));
    }
}
