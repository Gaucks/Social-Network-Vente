<?php

namespace Wishters\FrontBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Wishters\FrontBundle\Entity\Annonce;

class LoadAnnonceData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $lorem = "Lorem ipsum dolor sit amet occaecat cupidatat non proident,
                 sunt in culpa qui officia deserunt mollit anim id est laborum.";
        $lorem1 = "DE DISPO Calandre VW NEUVE golf VI gti ET GTD sanS sigle neuve
                   DE DISPO AUSSI DES CALES 20MM AVEC GOUJON 5/112
                   DE DISPO 2 JANTE DETROIT GTI EN 19 A REPEINDRE IDEAL";
        $lorem2 = "Joli débardeur couleur marron chocolat avec détail de pierres turquoises autour du décolleté,
                   de la marque italienne apepazza. 95% coton et 5% spandex.
                   Porté une seule fois, en parfait état, taille L (correspond au 42).
                    Contactez-nous au 04.93.99.25.50.";
        $lorem3 = "Mobile conçu pour apaiser bébé met en scène de jolis oursons. Une fonction projection fait de la chambre de bébé une douce nuit étoilée.
                    6 sons au choix (berceuse, classique, sons de la nature, musiques relaxantes...) et de nombreuses variations de lumières. 2 positions:
                    il s'attache aux barreaux du lit ou se pose sur la commode de la chambre. Astucieux : la télécommande permet à la maman de déclencher
                    le mobile à distance. Fonctionne avec 2 piles LR6 (télécommande) et 4 piles LR20 (mobile), non fournies.
                    Très bon état. Envoi possible";
        $lorem4 = "Sony xperia E bloque sur SFR vendu dans sa boite avec tous ses accessoires";
        $lorem5 = "royeur professionnel pour broyer sans effort des grandes quantitées de végétaux et des branches jusqu'à 9 cm diamètre.
                    Le broyeur dans la classe compact qui fonctionne comme il faut:
                    Moteur Honda tres fiable avec une longue duree de vie (garantie 3 ans).
                    Éjection des copeaux directement dans la remorque, benne ou brouet.
                    Auto-alimentation. Pas besoin de pousser
                    La goulotte d'éjection ne se bouche pas
                    Idéal pour elagueur, espaces verts et paysagiste.
                    Les avantages:
                    - compact
                    - rapide: jusqu'à 5 m3 de branches/h ou 24 stères/h
                    - auto alimentation
                    - pièces détachées de haute qualité
                    - construction tres rigide
                    - moteur Honda GX 390 13 ch. - 4 temps (Euro 95)
                    - construction Européenne
                    - SAV rapide et efficace
                    - livraison dans toute la France
                    Prix, fiches techniques et liens pour vidéo de démonstration sur demande par email (marquez votre code postal)";
        $lorem6 = 'Vend iMac de 2009 24"
                    Parfait etat suivie par Apple Store de lyon
                    Aucun défaut vendu avec sourie apple et clavier filaire
                    Os Maverick a jour
                    Côté 930Euro(s)
                    Vendu 850Euro(s) ou échange contre MacBook même cote';

        // Creation des categorys Multimédia

        $annonce1  = $this->createAnnonce('Calandre VW NEUVE golf 6 GTi ET GTD',
            $lorem1,
            '3000',
            $this->getReference('user-3'),
            $this->getReference('region-pa')
        );
        $annonce2  = $this->createAnnonce('Joli débardeur avec détail décolleté turquoise',
            $lorem2,
            '1120',
            $this->getReference('user-2'),
            $this->getReference('region-pa')
        );
        $annonce3  = $this->createAnnonce('MacBook Pro 2012 13Pouces',
            $lorem6,
            '1000',
            $this->getReference('user-2'),
            $this->getReference('region-li')
         );
        $annonce4  = $this->createAnnonce('Sony xperia E operateur sfr',
            $lorem4,
            '50',
            $this->getReference('user-4'),
            $this->getReference('region-pa')
        );
        $annonce5  = $this->createAnnonce('Téléphone portable Iphone 4S niquel',
            $lorem,
            '3200',
            $this->getReference('user-1'),
            $this->getReference('region-co')
        );
        $annonce6  = $this->createAnnonce('Un titre d\'annonce je sais pas',
            $lorem,
            '1000',
            $this->getReference('user-3'),
            $this->getReference('region-fra')
            );
        $annonce7  = $this->createAnnonce('Une porsche 911 cabriolet noir parfait état !',
            $lorem,
            '0',
            $this->getReference('user-2'),
            $this->getReference('region-al')
        );
        $annonce8  = $this->createAnnonce('Broyeur de branches compact -PRO-',
            $lorem5,
            '50',
            $this->getReference('user-1'),
            $this->getReference('region-fc')
        );
        $annonce9  = $this->createAnnonce('Opel Corsa bleu',
            $lorem,
            '100000',
            $this->getReference('user-0'),
            $this->getReference('region-bo')
        );
        $annonce10 = $this->createAnnonce('10 CD d\'Elvis presley !',
            $lorem,
            '1000',
            $this->getReference('user-4'),
            $this->getReference('region-pa')
        );
        $annonce11 = $this->createAnnonce('Mobile Doux Rêves Papillons Fisher Price',
            $lorem3,
            '1000',
            $this->getReference('user-2'),
            $this->getReference('region-fra')
        );
        $annonce12 = $this->createAnnonce('Canapé d\'angle 6 places taupe',
            $lorem,
            '1000',
            $this->getReference('user-1'),
            $this->getReference('region-mo')
        );

        // Enregistrement des annonces

        $manager->persist($annonce1);
        $manager->persist($annonce2);
        $manager->persist($annonce3);
        $manager->persist($annonce4);
        $manager->persist($annonce5);
        $manager->persist($annonce6);
        $manager->persist($annonce7);
        $manager->persist($annonce8);
        $manager->persist($annonce9);
        $manager->persist($annonce10);
        $manager->persist($annonce11);
        $manager->persist($annonce12);
        $manager->flush();
    }

    // Fonction de création globale
    private function createAnnonce($title, $content, $price, $user,$region) {
        $annonce = new Annonce();
        $annonce->setTitle($title)
                ->setContent($content)
                ->setPrice($price)
                ->setHashtag('annonce')
                ->setUser($user)
                ->setRegion($region)
        ;

        return $annonce;
    }

    public function getOrder()
    {
        return 3;
    }

}