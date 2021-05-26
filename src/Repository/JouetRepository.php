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

    }
}
