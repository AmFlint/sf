<?php

namespace App\Repository;

use App\Entity\Food;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Food|null find($id, $lockMode = null, $lockVersion = null)
 * @method Food|null findOneBy(array $criteria, array $orderBy = null)
 * @method Food[]    findAll()
 * @method Food[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FoodRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Food::class);
    }

    /**
     * @param string $foodName
     * @return food by its name if exists
     * @throws EntityNotFoundException
     */

    public function getFoodByName(string $foodName)
    {
        if (empty($foodName)) {
            throw new EntityNotFoundException();
        }

        return $this->findOneBy(
            array('foodName' => $foodName)
        );

//    /**
//     * @return Food[] Returns an array of Food objects
//     */
        /*
        public function findByExampleField($value)
        {
            return $this->createQueryBuilder('f')
                ->andWhere('f.exampleField = :val')
                ->setParameter('val', $value)
                ->orderBy('f.id', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
        }
        */

        /*
        public function findOneBySomeField($value): ?Food
        {
            return $this->createQueryBuilder('f')
                ->andWhere('f.exampleField = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }

        */
    }
}
