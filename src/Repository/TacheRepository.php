<?php

namespace App\Repository;

use App\Entity\Tache;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tache>
 *
 * @method Tache|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tache|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tache[]    findAll()
 * @method Tache[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TacheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tache::class);
    }

    public function save($name, $priority, $description, $status,$createdBy,$createdDate,$updatedBy,$updatedDate,$category): void
    {
        $tache = new Tache();
        $tache->setName($name);
        $tache->setPriority($priority);
        $tache->setDescription($description);
        $tache->setStatus($status);
        $tache->setCreatedBy($createdBy);
        $tache->setCreatedDate($createdDate);
        $tache->setUpdatedBy($updatedBy);
        $tache->setUpdatedDate($updatedDate);
        $tache->setCategory($category);
        $this->getEntityManager()->persist($tache);
        $this->getEntityManager()->flush();
    }

    public function update(Tache $tache): Tache
    {
        $this->getEntityManager()->persist($tache);
        $this->getEntityManager()->flush();

        return $tache;
    }

    public function remove(Tache $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

//    /**
//     * @return Tache[] Returns an array of Tache objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Tache
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
