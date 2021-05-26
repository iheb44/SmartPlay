<?php

namespace App\Controller;

use App\Entity\Fournisseur;
use App\Entity\Jouet;
use App\Repository\FournisseurRepository;
use App\Repository\JouetRepository;
use http\QueryString;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{

    private  $rep_Four;
    /**
     * @var JouetRepository
     */
    private  $for_jou;

    public function index(): Response
    {
       /* $this->ajouterFornisseur();
        $this->ajouterJouet();*/
      return  $this->render("home.html.twig");
    }
    public function __construct(FournisseurRepository $for_rep, JouetRepository $for_jou)
    {
    $this->rep_Four=$for_rep;
    $this->for_jou = $for_jou;
    }

    /*public function  ajouterFornisseur () {
        $entityManager = $this->getDoctrine()->getManager();
        $f = new Fournisseur();
        $f2 = new fournisseur();
        $f3 = new fournisseur();
        $f->setCodeFour(1);
        $f->setDesFour("PlayTunisia");
        $f2->setCodeFour(2);
        $f2->setDesFour("ImportSmart");
        $f3->setCodeFour(3);
        $f3->setDesFour("EduGame");
        $entityManager->persist($f);
        $entityManager->flush($f);
        $entityManager->persist($f2);
        $entityManager->flush($f2);
        $entityManager->persist ($f3);
        $entityManager->flush($f3);
    }public function ajouterJouet()
    {
        $joue = new Jouet() ;
        $four = $this->rep_Four->find(2) ;
        $joue->setCodeJouet(1)
            ->setDesJouet("Camionnette Lego")
            ->setQteStockJouet(130)
            ->setPUJouet(20000)
            ->setCodeFourJouet($four) ;
        $this->getDoctrine()->getManager()->persist($joue) ;
        $joue = new Jouet() ;
        $four = $this->rep_Four->find(2) ;
        $joue->setCodeJouet(2)
            ->setDesJouet("Voiture télécommandée")
            ->setQteStockJouet(120)
            ->setPUJouet(45.400)
            ->setCodeFourJouet($four) ;
        $this->getDoctrine()->getManager()->persist($joue) ;
        $joue = new Jouet() ;
        $four = $this->rep_Four->find(3) ;
        $joue->setCodeJouet(3)
            ->setDesJouet("Puzzle La reine des neiges")
            ->setQteStockJouet(300)
            ->setPUJouet(3)
            ->setCodeFourJouet($four) ;
        $this->getDoctrine()->getManager()->persist($joue) ;
        $joue = new Jouet() ;
        $four = $this->rep_Four->find(3) ;
        $joue->setCodeJouet(4)
            ->setDesJouet("Scrabble")
            ->setQteStockJouet(270)
            ->setPUJouet(32.000)
            ->setCodeFourJouet($four) ;
        $this->getDoctrine()->getManager()->persist($joue) ;
        $joue = new Jouet() ;
        $four = $this->rep_Four->find(3) ;
        $joue->setCodeJouet(5)
            ->setDesJouet("Monopoly")
            ->setQteStockJouet(300)
            ->setPUJouet(34.600)
            ->setCodeFourJouet($four) ;
        $this->getDoctrine()->getManager()->persist($joue) ;
        $this->getDoctrine()->getManager()->flush() ;
    }*/

}
