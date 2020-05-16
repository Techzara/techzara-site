<?php

namespace App\Repository;

use App\Entity\ChallengePerCandidat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChallengePerCandidat|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChallengePerCandidat|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChallengePerCandidat[]    findAll()
 * @method ChallengePerCandidat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChallengePerCandidatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChallengePerCandidat::class);
    }

    // /**
    //  * @return ChallengePerCandidat[] Returns an array of ChallengePerCandidat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ChallengePerCandidat
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
