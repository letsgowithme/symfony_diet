<?php

namespace App\Repository;

use App\Service\PasswordGenerator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PasswordGenerator>
 *
 * @method PasswordGenerator|null find($id, $lockMode = null, $lockVersion = null)
 * @method PasswordGenerator|null findOneBy(array $criteria, array $orderBy = null)
 * @method PasswordGenerator[]    findAll()
 * @method PasswordGenerator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PasswordGeneratorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PasswordGenerator::class);
    }

    public function save(PasswordGenerator $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PasswordGenerator $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    
//    /**
//     * @return PasswordGenerator[] Returns an array of PasswordGenerator objects
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

//    public function findOneBySomeField($value): ?PasswordGenerator
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
