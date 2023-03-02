<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Panier;
use App\Entity\Processeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Processeur>
 *
 * @method Processeur|null   find($id, $lockMode = null, $lockVersion = null)
 * @method Processeur|null   findOneBy(array $criteria, array $orderBy = null)
 * @method array<Processeur> findAll()
 * @method array<Processeur> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcesseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Processeur::class);
    }

    public function save(Processeur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Processeur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * It returns the 10 cheapest CPU's that are compatible with the motherboard in the cart.
    *
    * @param Panier panier The panier object that we're using to find the compatible CPU
    *
    * @return array An array of CarteGraphique objects
    */
   public function findAllByPanier(Panier $panier): array
   {
       if (null != $panier->getCarteMere()) {
           $socket = $panier->getCarteMere()->getSocket();
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

//    /**
//     * @return Processeur[] Returns an array of Processeur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Processeur
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}