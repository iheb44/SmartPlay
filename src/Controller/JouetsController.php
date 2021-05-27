<?php

namespace App\Controller;

use App\Entity\Fournisseur;
use App\Entity\Jouet;
use App\Form\Type\jouetType;
use App\Repository\JouetRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class JouetsController extends AbstractController
{
    /**
     * @var JouetRepository
     */
    private  $for_jou;

    /**
     * @Route("/jouets", name="jouets")
     */

    public function index(): Response
    {
        $this->Requete1();
        $this->Requete2();
       $this->Requete3();
       $this->Requete4();
       $this->Requete5();
        $tabjouet = $this->for_jou->findAll();
        return $this->render('jouets/index.html.twig', [
            'jouets' => $tabjouet,
        ]);
    }
    public function __construct(JouetRepository $for_jou)
    {
        $this->for_jou = $for_jou;
    }

    /**
     * @Route("/jouets/delete/{id}", name="delete_jouet")
     * @param $id
     */

    public function delete_jouet($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $jouet = $entityManager->getRepository(Jouet::class)->find($id);
        $entityManager->remove($jouet);
        $entityManager->flush();
        return $this->redirectToRoute("jouets");
    }

    /**
     * @Route("/jouets/new", name="new_jouet")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function ajouter_jouet(Request $request){
            $jouet = new jouet();
            $builder = $this->createForm(jouetType::class,$jouet);

            $builder->handleRequest($request);

            if($builder->isSubmitted() && $builder->isValid()) {
                $jouet = $builder->getData();

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($jouet);
                $entityManager->flush();

                return $this->redirectToRoute('jouets');
            }
            return $this->render('jouets/new.html.twig',['form' => $builder->createView()]);
        }

    /**
     * @Route("/article/edit/{id}", name="edit_jouet")
     * Method({"GET", "POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(Request $request, $id) {
        //$jouet = new Jouet();
        $jouet = $this->getDoctrine()->getRepository(Jouet::class)->find($id);

        $form = $this->createForm(jouetType::class,$jouet);


        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('jouets');
        }

        return $this->render('jouets/editjouet.html.twig', ['form' => $form->createView()]);
    }

     public function Requete1()
    {
        $jouets = $this->getDoctrine()->getRepository(Jouet::class)->findBy(array('code_four_jouet' => '2'));
        echo  "Ex1 : ". "<br>";
        foreach ($jouets as $value) {
            echo  "jouet : " . $value->getDesJouet() . "<br>";
        }
    }
    public function Requete2()
    {
        $jouets = $this->getDoctrine()->getRepository(Jouet::class)->maxQteJouet(true);
        echo  "Ex2 : ". "<br>";
        foreach ($jouets as $key => $jouet) {
            foreach ($jouet as  $value)
            echo  "Le jouet num".($key+1)." : " . $value . "<br>";
        }
    }
    public function Requete3()
    {
        $jouets = $this->getDoctrine()->getRepository(Jouet::class)->minQteJouet();
        echo  "Ex3 : ". "<br>";
        foreach ($jouets as $key => $jouet) {
            foreach ($jouet as  $value)
                echo  "Le jouet num".($key+1)." : " . $value . "<br>";
        }
    }
    public function Requete4()
    {
        $fours = $this->getDoctrine()->getRepository(Jouet::class)->maxQteJouet(false, true);
        foreach ($fours as $key => $four) {
                echo  "Le Four num".($key+1)." : " . $four['des_four'] . "<br>";
        }
    }
    public function Requete5()
    {
        $arr = $this->getDoctrine()->getRepository(Jouet::class)->allfour();
        $arrFour = $this->getDoctrine()->getRepository(Fournisseur::class)->fourNoJouet($arr);
        $res = array_diff(array_unique([$arr]), [$arrFour]);
        dd($res);
    }
    public function Requete6()
    {
        $this->getDoctrine()->getRepository(Jouet::class)->updatePrice(10);
        $jouet = $this->getDoctrine()->getRepository(Jouet::class)->findAll();
        foreach ($jouet as $value) {
            echo  "jouet Description : " . $value->getDesJouet() . " Price : " . $value->getPUJouet() ."<br>";
        }
    }
    public function Requete7() {
        $this->getDoctrine()->getRepository(Jouet::class)->deleteFourAndGame();
        $jouet = $this->getDoctrine()->getRepository(Jouet::class)->findAll();
        foreach ($jouet as $value) {
            echo  "jouet Description : " . $value->getDesJouet() . " Price : " . $value->getPUJouet() ."<br>";
        }
    }


}
