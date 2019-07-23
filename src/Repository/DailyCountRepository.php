<?php

namespace App\Repository;

use App\Entity\DailyCount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DailyCount|null find($id, $lockMode = null, $lockVersion = null)
 * @method DailyCount|null findOneBy(array $criteria, array $orderBy = null)
 * @method DailyCount[]    findAll()
 * @method DailyCount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DailyCountRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DailyCount::class);
    }

    public function resetCount()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "UPDATE daily_count SET count = 0";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    // /**
    //  * @return DailyCount[] Returns an array of DailyCount objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DailyCount
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
