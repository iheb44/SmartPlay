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
        $jouet = new Jouet();
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

}
