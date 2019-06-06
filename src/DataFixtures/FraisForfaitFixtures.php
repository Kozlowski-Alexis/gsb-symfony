<?php

namespace App\DataFixtures;
use App\Entity\FraisForfait;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class FraisForfaitFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $fraisForfait = new FraisForfait();
        $fraisForfait->setLibelle('Forfait Etape');
        $fraisForfait->setMontant(115);
        $manager->persist($fraisForfait);
        $manager->flush();

        $fraisForfait = new FraisForfait();
        $fraisForfait->setLibelle('Frais Kilométrique');
        $fraisForfait->setMontant(1.5);
        $manager->persist($fraisForfait);
        $manager->flush();

        $fraisForfait = new FraisForfait();
        $fraisForfait->setLibelle('Nuitée Hôtel');
        $fraisForfait->setMontant(80);
        $manager->persist($fraisForfait);
        $manager->flush();

        $fraisForfait = new FraisForfait();
        $fraisForfait->setLibelle('Repas Restaurant');
        $fraisForfait->setMontant(18);
        $manager->persist($fraisForfait);
        $manager->flush();
    }
}