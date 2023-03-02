<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CarteMere;
use App\Entity\Panier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CarteMere>
 *
 * @method CarteMere|null   find($id, $lockMode = null, $lockVersion = null)
 * @method CarteMere|null   findOneBy(array $criteria, array $orderBy = null)
 * @method array<CarteMere> findAll()
 * @method array<CarteMere> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarteMereRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarteMere::class);
    }

    public function save(CarteMere $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CarteMere $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * It returns the 10 cheapest cartes mères compatible with the processeur of the panier.
    *
    * @param Panier panier The panier object that we're using to find compatible components
    *
    * @return array An array of CarteMere objects
    */
   public function findAllByPanier(Panier $panier): array
   {
       if (null != $panier->getProcesseur()) {
           $socket = $panier->getProcesseur()->getSocket();
       } else {
           return $this->findAll();
       }

       return $this->createQueryBuilder('c')
           ->andWhere('c.socket = :val')
           ->setParameter('val', $socket)
           ->orderBy('c.price', 'ASC')
           ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?CarteMere
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}