<?php

namespace App\Repository;

use App\Entity\LigneFraisForfait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LigneFraisForfait|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneFraisForfait|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneFraisForfait[]    findAll()
 * @method LigneFraisForfait[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneFraisForfaitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LigneFraisForfait::class);
    }

    public function getTotalByFiche($id)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT SUM(ff.montant * lff.quantite) as montant
                FROM App\Entity\FraisForfait ff, App\Entity\LigneFraisForfait lff
                WHERE lff.ficheFrais = :idFiche AND ff.id = lff.fraisForfait'
        )->setParameter('idFiche', $id);
        return $query->execute();
    }

    // /**
    //  * @return LigneFraisForfait[] Returns an array of LigneFraisForfait objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LigneFraisForfait
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
