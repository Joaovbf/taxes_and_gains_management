<?php

namespace App\Repository;

use App\Entity\Withdraw;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Withdraw>
 *
 * @method Withdraw|null find($id, $lockMode = null, $lockVersion = null)
 * @method Withdraw|null findOneBy(array $criteria, array $orderBy = null)
 * @method Withdraw[]    findAll()
 * @method Withdraw[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WithdrawRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Withdraw::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Withdraw $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Withdraw $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findOrFail($id){
        $entity = $this->find($id);
        if ($entity == null) {
            throw new \Exception("Couldnt find this entity");
        }
        return $entity;
    }

    // /**
    //  * @return Withdraw[] Returns an array of Withdraw objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Withdraw
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
