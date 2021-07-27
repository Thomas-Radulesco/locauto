<?php

namespace App\Repository;

use App\Entity\Vehicle;
use Doctrine\ORM\Query;
use App\Entity\AvailableVehicleSearch;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;

/**
 * @method Vehicle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicle[]    findAll()
 * @method Vehicle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    /**
     * Gets available vehicles from DB
     *
     * @param AvailableVehicleSearch $search
     * @return array
     */
    public function findAllAvailableVehicle(AvailableVehicleSearch $search): array 
    {
        // $search initiated on homepage, see HomeController 
        $query = $this->createQueryBuilder('v');

        $query
            ->select('v')                           // select vehicle
            ->leftJoin('v.orders', 'o')             // join orders informations : we have a relation $orders in the Vehicle entity, which is a collection
            ->where('o.datetimeFrom > :endDate')    // we take the vehicle if it is already ordered after the end of the current search 
            ->orWhere('o.datetimeTo < :beginDate')  // we take the vehicle if it is returned before the beginning of the current search
            ->orWhere('o.datetimeFrom IS NULL')     // we take the vehicle if it is not ordered
            ->orWhere('o.datetimeTo IS NULL')       // idem
            ->setParameter('beginDate', $search->getFromDate()->format('Y-m-d H:i:s'))
            ->setParameter('endDate', $search->getToDate()->format('Y-m-d H:i:s'));

        return $query->getQuery()->getArrayResult();
    }
    // /**
    //  * @return Vehicle[] Returns an array of Vehicle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vehicle
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
