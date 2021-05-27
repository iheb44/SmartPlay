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
    /*
    public function findByFour($code)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.code_four_jouet = :four')
            ->setParameter('four',$code)
            ->getQuery()
            ->getResult();

    }
    public function findByMaxQte()
    {
        $maxqte = $this->createQueryBuilder('j')
            ->select('max(j.qte_stock_jouet')
            ->getQuery()
            ->getResult();
        return $this->createQueryBuilder('j')
            ->where('j.qte_stock_jouet = :var')
            ->setParameter('var',$maxqte)
            ->getQuery()
            ->getResult();

    }
    public function findByMinPrice()
    {
        $minprice = $this->createQueryBuilder('j')
            ->select('min(j.PU_jouet')
            ->getQuery()
            ->getResult();
        return $this->createQueryBuilder('j')
            ->where('j.PU_jouet= :var')
            ->setParameter('var',$minprice)
            ->getQuery()
            ->getResult();

    }
    public function supp()
    {
        $val = 3;
        $rep1 = $this->getEntityManager();
        $reqq = $rep1->createQuery('DELETE FROM App\Entity\Jouet J WHERE J.code_four_jouet = :val')->setParameter('val',$val);
        $reqq->execute();
        $rep1 = $this->getEntityManager();
        $reqq = $rep1->createQuery('DELETE FROM App\Entity\Fornisseur F WHERE F.code_four = :val')->setParameter('val',$val);
        $reqq ->execute();
        $rep = $this->getEntityManager();
        $reqq = $rep->createQuery('SELECT J FROM App\Entity\Jouet J');
        return $reqq->getResult();
    }
    public function maj()
    {
        $val = 2;
        $prixsupp = 130;
        $rep1 = $this->getEntityManager();
        $reqq = $rep1->createQuery('UPDATE App\Entity\Jouet J SET J.PU_jouet = J.PU_jouet+:var WHERE j.code_four_jouet = :val')
            ->setParameter('var',$prixsupp)
            ->setParameter('val',$val);

        $reqq->execute();
        $rep1 = $this->getEntityManager();
        $reqq = $rep1->createQuery('SELECT J FROM App\Entity\Jouet J WHERE J.code_four_jouet = :val')->setParameter('val',$val);
        return $reqq ->getResult();

    }*/


    public function maxPriceJouet()
    {
        $query = $this->createQueryBuilder('j')
            ->select('MAX(j.qte_stock_jouet)');
        return $this->maxMinStockJouet((int)$query->getQuery()->getResult()[0][1]);
    }
    public function minPriceJouet()
    {
        $query = $this->createQueryBuilder('j')
            ->select('MIN(j.qte_stock_jouet)');
        return $this->maxMinStockJouet((int)$query->getQuery()->getResult()[0][1]);
    }
    public function maxMinStockJouet($price)
    {
        return $this->createQueryBuilder('j')
            ->select('j.des_jouet')
            ->where('j.qte_stock_jouet = :p')
            ->setParameter('p', $price)
            ->getQuery()->getResult();
    }
    /**
     * @return Jouet[] Returns a Jouet with min price
     */
    public function minPrice()
    {
        return $this->getEntityManager()->createQuery(
            "SELECT j FROM App\Entity\Jouet j 
             WHERE j.PU_jouet = (SELECT MIN(t.PU_jouet) from App\Entity\Jouet t)       
          "
        )->getResult();
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
