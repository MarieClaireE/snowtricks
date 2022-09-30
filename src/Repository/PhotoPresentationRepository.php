<?php

namespace App\Repository;

use App\Entity\PhotoPresentation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PhotoPresentation>
 *
 * @method PhotoPresentation|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoPresentation|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoPresentation[]    findAll()
 * @method PhotoPresentation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoPresentationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotoPresentation::class);
    }

    public function add(PhotoPresentation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PhotoPresentation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PhotoPresentation[] Returns an array of PhotoPresentation objects
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

//    public function findOneBySomeField($value): ?PhotoPresentation
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
