<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setNom('David');
        $user->setPrenom('Durand');
        $user->setUsername('demo');
        $user->setPassword($this->encoder->encodePassword($user, 'demo'));
        $user->setAdresse('Avenue Charle de Gaulle');
        $user->setCp('42000');
        $user->setVille('Saint-Etienne');
        $user->setDateEmbauche(new \DateTime());
        $manager->persist($user);
        $manager->flush();

        $user = new User();
        $user->setNom('Christoph');
        $user->setPrenom('Dubois');
        $user->setUsername('test');
        $user->setPassword($this->encoder->encodePassword($user, 'test'));
        $user->setAdresse("7 rue de l'impasse");
        $user->setCp('75000');
        $user->setVille('Paris');
        $user->setDateEmbauche(new \DateTime());
        $manager->persist($user);
        $manager->flush();
    }
}
