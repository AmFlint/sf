<?php

namespace App\Repository;

use App\Entity\Cat;
use App\Entity\Food;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method Cat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cat[]    findAll()
 * @method Cat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cat::class);
    }

    public function save(Cat $cat)
    {
       $em = $this->getEntityManager();

       $em->persist($cat->getColor());
       $em->persist($cat->getMood());

       $em->persist($cat);
       $em->flush();
    }

    /**
     * @param int $catId
     * @throws ORMException
     * @throws NotFoundHttpException
     * @return null|Cat
     */
    public function findByIdAndDelete(int $catId)
    {
        $cat = $this->find($catId);
        // Not found
        if (empty($cat)) {
            return null;
        }

        $this->getEntityManager()->remove($cat);
        return $cat;
    }

//    /**
//     * @return Cat[] Returns an array of Cat objects
//     */
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
    public function findOneBySomeField($value): ?Cat
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
