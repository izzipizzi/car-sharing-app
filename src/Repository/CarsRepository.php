<?php

namespace App\Repository;

use App\Entity\Cars;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cars|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cars|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cars[]    findAll()
 * @method Cars[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cars::class);
    }

    public function removeCarByID($id)
    {

        $db = $this->createQueryBuilder('c')
            ->delete()
            ->where('c.id=:id')
            ->setParameter('id',$id);
        return $db->getQuery()->execute();

    }
    public function findFreeCars(int $carID = null)
    {
        $db = $this->createQueryBuilder('c')
            ->where('c.status = :status')
            ->setParameter('status','FREE')
            ->orderBy('c.name','DESC');
//        if ($carID){
//            $db->andWhere('c.')
//        }

        return $db->getQuery()->getResult();
    }
    public function findAllCars(int $carID = null)
    {

        $db = $this->createQueryBuilder('c')
            ->select('c, t')
            ->innerJoin('c.type_id','t')
            ->orderBy('c.name','DESC');
        return $db->getQuery()->getResult();
    }
    public function updateCarStatus(int $carID,string $status){
        $db = $this->createQueryBuilder('c')
            ->update()
            ->set('c.status','?1')
            ->where('c.id = :id')
            ->setParameter('id' ,$carID)
            ->setParameter(1 ,$status);
        return $db->getQuery()->execute();
    }

    public function updateCarDateToAndLocation(int $carID,\DateTime $dateTime,$time,$location){
        $db = $this->createQueryBuilder('c')
            ->update()
            ->set('c.dateTo','?1')
            ->set('c.time_to','?2')
            ->set('c.location','?3')
            ->where('c.id = :id')
            ->setParameter('id' ,$carID)
            ->setParameter(1 ,$dateTime)
            ->setParameter(2 ,$time)
            ->setParameter(3 ,$location);
        return $db->getQuery()->execute();
    }

    public function setExpiredTrigger($carID,$date){
        $sql = 'CREATE OR REPLACE EVENT  event_'.$carID.'
                    ON SCHEDULE
                        AT "'.$date->format('Y-m-d H:i:s').'" 
                    ON COMPLETION
                        PRESERVE ENABLE
                DO
                    UPDATE cars
                        SET status = "FREE"
                    WHERE id = '.$carID.';';
         $em = $this->getEntityManager();
    $stmt = $em->getConnection()->prepare($sql);
    return $stmt->execute();

    }
    // /**
    //  * @return Cars[] Returns an array of Cars objects
    //  */
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


//    public function findOneByID($value): ?Cars
//    {
//        try {
//            return $this->createQueryBuilder('c')
//                ->andWhere('c.id = :val')
//                ->setParameter('id', intval($value))
//                ->getQuery()
//                ->execute();
//        } catch (NonUniqueResultException $e) {
//        }
//    }

}
