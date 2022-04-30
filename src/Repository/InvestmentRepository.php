<?php

namespace App\Repository;

use App\Entity\Investment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Investment>
 *
 * @method Investment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Investment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Investment[]    findAll()
 * @method Investment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvestmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Investment::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Investment $entity, bool $flush = true): void
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
    public function remove(Investment $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findByUserPaginated(PaginatorInterface $paginator, $user_id, $page, $perPage)
    {
        $query = $this->createQueryBuilder('i')
            ->andWhere('i.user = :val')
            ->setParameter('val', $user_id)
            ->orderBy('i.id', 'ASC')
            ->getQuery();
        return $paginator->paginate(
            $query, /* query NOT result */
            $page, /*page number*/
            $perPage /*limit per page*/
        );

    }
    // /**
    //  * @return Investment[] Returns an array of Investment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Investment
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
