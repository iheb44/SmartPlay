<?php

namespace App\Repository;

use App\Entity\Jouet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Jouet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jouet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jouet[]    findAll()
 * @method Jouet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JouetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Jouet::class);
    }


    // /**
    //  * @return Jouet[] Returns an array of Jouet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Jouet
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */



    public function maxQteJouet($req1 = false , $req4 = false)
    {
        $query = $this->createQueryBuilder('j');
        $query ->select('MAX(j.qte_stock_jouet)');
        $qte = (int)$query->getQuery()->getResult()[0][1];
        if ($req1){
            return $this->maxMinStockJouet($qte);
        }
        if ($req4){
            return $this->fourMaxStockJouet($qte);

        }
    }
    public function minPUJouet()
    {
        $query = $this->createQueryBuilder('j')
            ->select('MIN(j.PU_jouet)');
        $qte = (int) $query->getQuery()->getResult()[0][1];
        return $this->nomjouet($qte);
    }
    public function nomjouet($qte)
    {
        return $this->createQueryBuilder('j')
            ->select('j.des_jouet')
            ->where('j.PU_jouet = :p')
            ->setParameter('p', $qte)
            ->getQuery()->getResult();
    }
    public function maxMinStockJouet($qte)
    {
        return $this->createQueryBuilder('j')
            ->select('j.des_jouet')
            ->where('j.qte_stock_jouet = :p')
            ->setParameter('p', $qte)
            ->getQuery()->getResult();
    }

    public function fourMaxStockJouet($qte)
    {
        return $this->createQueryBuilder('j')
                ->select('j, f.des_four')
                ->innerJoin('j.code_four_jouet', 'f', 'f.id = j.code_four_jouet')
                ->having('j.qte_stock_jouet = :q')
                ->setParameter('q', $qte)
            ->getQuery()->getResult();
    }

    public function allfour()
    {
        $sub = $this->createQueryBuilder('j')
            ->select('IDENTITY(j.code_four_jouet) as four');
        $arr = implode(', ', array_map(function ($entry) {
            return $entry['four'];
        }, $sub->getQuery()->getResult()));

        return $arr;
    }


    public function updatePrice($price) {
        $queryGetFour = $this->getEntityManager()
            ->createQueryBuilder()
            ->select("f.code_four")
            ->from("App\Entity\Fournisseur","f")
            ->where("f.des_four = 'ImportSmart'")
            ->getQuery()
            ->getResult();
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->update("App\Entity\Jouet","j")
            ->set("j.PU_jouet","j.PU_jouet + :price")
            ->where("IDENTITY(j.code_four_jouet) = :query")
            ->setParameter("price",$price)
            ->setParameter("query",$queryGetFour)
            ->getQuery()
            ->getResult();
    }
    public function deleteFourAndGame() {
        $queryGetFourId = $this->getEntityManager()
            ->createQueryBuilder()
            ->select("f.code_four")
            ->from("App\Entity\Fournisseur","f")
            ->where("f.des_four = 'EduGame'")
            ->getQuery()
            ->getResult();
        $this->getEntityManager()
            ->createQueryBuilder()
            ->delete("App\Entity\Jouet","j")
            ->where("IDENTITY(j.code_four_jouet) = :query")
            ->setParameter("query",$queryGetFourId)
            ->getQuery()
            ->getResult();
        $this->getEntityManager()
            ->createQueryBuilder()
            ->delete("App\Entity\Fournisseur","f")
            ->where("f.code_four = :query")
            ->setParameter("query",$queryGetFourId)
            ->getQuery()
            ->getResult();
    }

}
