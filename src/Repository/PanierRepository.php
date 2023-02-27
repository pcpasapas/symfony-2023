<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Panier;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Panier>
 *
 * @method Panier|null   find($id, $lockMode = null, $lockVersion = null)
 * @method Panier|null   findOneBy(array $criteria, array $orderBy = null)
 * @method array<Panier> findAll()
 * @method array<Panier> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PanierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Panier::class);
    }

    public function save(Panier $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Panier $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getPanierInArray(string|int $id): array
    {
        $panier = $this->find($id);

        return [
            'Boitier' => $panier->getBoitier(),
            'Alimentation' => $panier->getAlimentation(),
            'Processeur' => $panier->getProcesseur(),
            'CarteMere' => $panier->getCarteMere(),
            'CarteGraphique' => $panier->getCarteGraphique(),
            'Ram' => $panier->getRam(),
            'Hdd' => $panier->getHdd(),
            'Ssd' => $panier->getSsd(),
        ];
    }

   /**
    * @return array<Panier> Returns an array of Panier objects
    */
   public function findByUser(?User $value): array
   {
       return $this->createQueryBuilder('p')
           ->andWhere('p.user = :val')
           ->setParameter('val', $value)
           ->orderBy('p.created_at', 'DESC')
           ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneByUsername($value): ?Panier
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.user = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
