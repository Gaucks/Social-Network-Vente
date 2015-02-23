<?php

namespace Wishters\FrontBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Wishters\UserBundle\Entity\Avatar;

class LoadUserData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface {

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {

        $userManager = $this->container->get('fos_user.user_manager');

        // John Doe
        $user0 = $this->createUser($userManager,'John', 'john@do.com', 'ac150910', $this->getReference('region-pa'), true, 'user-1.jpg' );
        // Amandine G
        $user1 = $this->createUser($userManager,'AmandineG', 'amandine_d89@yahoo.fr', 'ac150910', $this->getReference('region-gd'), true, 'amandine.jpg' );
        // Christophe Gautier
        $user2 = $this->createUser($userManager,'Kris', 'gaucks@gmail.com', 'ac150910', $this->getReference('region-pa'), true,'user-2.jpg' );
        // Guest
        $user3 = $this->createUser($userManager,'Guest', 'guest@gmail.com', 'ac150910', $this->getReference('region-li'), true,'user-3.jpg' );
        //Jeremy
        $user4 = $this->createUser($userManager,'JeremyG', 'jeremyg@gmail.com', 'ac150910', $this->getReference('region-pa'), true,'user-4.jpg' );
        //Emma
        $user5 = $this->createUser($userManager,'EmmaG', 'emmag@gmail.com', 'ac150910', $this->getReference('region-pa'), true,'user-5.jpg' );
        //Jappy
        $user6 = $this->createUser($userManager,'Jappy', 'jappy@gmail.com', 'ac150910', $this->getReference('region-pa'), true,'user-6.jpg' );

        // On sauvegarde en mémoires
        $manager->persist($user0);
        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->persist($user4);
        $manager->persist($user5);
        $manager->persist($user6);

        // Enregistrement
        $manager->flush();


        //Ajout des références pour les données à enregistrer
        $this->addReference('user-0', $user0);
        $this->addReference('user-1', $user1);
        $this->addReference('user-2', $user2);
        $this->addReference('user-3', $user3);
        $this->addReference('user-4', $user4);
        $this->addReference('user-5', $user5);
        $this->addReference('user-6', $user6);

    }

    public function createUser($userManager, $username, $email, $pwd, $region, $enabled, $avatar)
    {
        $user = $userManager->createUser();

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPlainPassword($pwd);
        $user->setRegion($region);
        $user->setAvatar($this->Avatar($avatar));
        $user->setEnabled($enabled);

        return $user;
    }

    public function Avatar($img)
    {
        $avatar = new Avatar();
        $avatar->setPath($img);

        return $avatar;
    }

    public function getOrder()
    {
        return 2;
    }
}