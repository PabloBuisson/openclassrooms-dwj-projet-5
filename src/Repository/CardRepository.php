<?php

namespace App\Repository;

use App\Entity\Card;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Card|null find($id, $lockMode = null, $lockVersion = null)
 * @method Card|null findOneBy(array $criteria, array $orderBy = null)
 * @method Card[]    findAll()
 * @method Card[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Card::class);
    }

    // /**
    //  * @return Card[] Returns an array of Card objects
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
    public function findOneBySomeField($value): ?Card
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param $today
     * @return Product[]
     */
    public function findDailyCards($today, $limit): array
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query

        $today->setTime(23, 59, 59); // today is saved as the end of the day, to fetch all the card due today

        $qb = $this->createQueryBuilder('p')
/*          ->select('p')
            ->innerJoin('p.tags', 't', 'WITH', 't.id = :id')
            ->where('p.id = :id') */
            ->andWhere('p.datePublication <= :today')
            ->orderBy('p.datePublication', 'ASC')
            ->setParameter('today', $today)
            ->setMaxResults($limit)
            ->getQuery();

        return $qb->execute();

        // to get just one result:
        // $product = $qb->setMaxResults(1)->getOneOrNullResult();
    }
}
