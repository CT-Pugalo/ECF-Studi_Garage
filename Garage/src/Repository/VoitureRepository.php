<?php

namespace App\Repository;

use App\Entity\Voiture;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Voiture>
 *
 * @method Voiture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Voiture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Voiture[]    findAll()
 * @method Voiture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoitureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voiture::class);
    }

    public function getAll(): array
    {
        return $this->createQueryBuilder('u')->getQuery()->getResult();
    }

    public function getMaxKm(): array
    {
        $res = $this->createQueryBuilder('Voiture')
        ->select('Voiture.kilometrage')
        ->addOrderBy('Voiture.kilometrage', Criteria::DESC)
        ->getQuery()->getResult();
        $res = array_slice($res, 0, 1);

        return $res;
    }
    public function getMinKm(): array
    {
        $res = $this->createQueryBuilder('Voiture')
        ->select('Voiture.kilometrage')
        ->addOrderBy('Voiture.kilometrage', Criteria::ASC)
        ->getQuery()->getResult();
        $res = array_slice($res, 0, 1);
        
        return $res;
    }

    public function getMaxPrix(): array
    {
        $res = $this->createQueryBuilder('Voiture')
        ->select('Voiture.prix')
        ->addOrderBy('Voiture.prix', Criteria::DESC)
        ->getQuery()->getResult();
        $res = array_slice($res, 0, 1);

        return $res;
    }
    public function getMinPrix(): array
    {
        $res = $this->createQueryBuilder('Voiture')
        ->select('Voiture.prix')
        ->addOrderBy('Voiture.prix', Criteria::ASC)
        ->getQuery()->getResult();
        $res = array_slice($res, 0, 1);

        return $res;
    }

    public function getMaxAnnee(): array
    {
        $res = $this->createQueryBuilder('Voiture')
        ->select('Voiture.annee_circulation')
        ->addOrderBy('Voiture.annee_circulation', Criteria::DESC)
        ->getQuery()->getResult();
        $res = array_slice($res, 0, 1);

        return $res;
    }
    public function getMinAnnee(): array
    {
        $res = $this->createQueryBuilder('Voiture')
        ->select('Voiture.annee_circulation')
        ->addOrderBy('Voiture.annee_circulation', Criteria::ASC)
        ->getQuery()->getResult();
        $res = array_slice($res, 0, 1);

        return $res;
    }

//    /**
//     * @return Voiture[] Returns an array of Voiture objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Voiture
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
