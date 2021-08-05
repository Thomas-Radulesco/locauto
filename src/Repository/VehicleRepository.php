<?php

namespace App\Repository;

use App\Entity\Vehicle;
use Doctrine\ORM\Query;
use App\Entity\AvailableVehicleSearch;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method Vehicle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicle[]    findAll()
 * @method Vehicle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleRepository extends ServiceEntityRepository
{

    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Vehicle::class);
        $this->entityManager = $entityManager;
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
        $query = $this->entityManager->createQueryBuilder('v');
        $unavailableVehicles =  $this->entityManager->createQueryBuilder('v');

        $unavailableVehicles
            ->select('v')
            ->from('App\Entity\Vehicle', 'v')
            ->join('App\Entity\Order', 'o', 'WITH', 'v.id = o.vehicleId')
            ->groupBy('v')
            ->andWhere($unavailableVehicles->expr()->between('o.datetimeFrom', ':beginDate', ':endDate'))
            ->orWhere($unavailableVehicles->expr()->between('o.datetimeTo', ':beginDate', ':endDate'))
            ->orWhere($unavailableVehicles->expr()->between(':beginDate', 'o.datetimeFrom', 'o.datetimeTo'))
            ->orWhere($unavailableVehicles->expr()->between(':endDate', 'o.datetimeFrom', 'o.datetimeTo'))
            ->setParameter('beginDate', $search->getFromDate()->format('Y-m-d H:i:s'))
            ->setParameter('endDate', $search->getToDate()->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getArrayResult()
        ;
        
        if ($unavailableVehicles->getQuery()->getArrayResult() == null) {
            return $this->findAll();
        }

        $query
            ->select('v')
            ->from('App\Entity\Vehicle', 'v')   // select vehicle
            ->groupBy('v')
            ->andWhere($query->expr()->notIn('v', ':unavailableVehicles'))
            ->setParameter('unavailableVehicles', $unavailableVehicles->getQuery()->getArrayResult())
        ;

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
