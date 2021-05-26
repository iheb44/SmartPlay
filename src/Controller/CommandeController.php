<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\Type\cmdType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;


class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="commande")
     */
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $cmds = $entityManager->getRepository(Commande::class)->findAll();
        return $this->render('commande/index.html.twig', [
            'cmds' => $cmds,
        ]);
    }
    /**
     * @Route("/commande/delete/{id}", name="delete_commande")
     * @param $id
     */

    public function delete_commande($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $cmd = $entityManager->getRepository(Commande::class)->find($id);
        $entityManager->remove($cmd);
        $entityManager->flush();
        return $this->redirectToRoute("commande");
    }
    /**
     * @Route("/commande/new", name="new_cmd")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function ajouter_cmd(Request $request){
        $cmd = new Commande();
        $builder = $this->createForm(cmdType::class,$cmd);

        $builder->handleRequest($request);

        if($builder->isSubmitted() && $builder->isValid()) {
            $date = new \DateTime();
            $cmd = $builder->getData();
            $cmd->setDateCde($date->format('d-m-Y'));
            $cmd->setHeureCde($date->format('H:i:s'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cmd);
            $entityManager->flush();

            return $this->redirectToRoute('commande');
        }
        return $this->render('commande/new.html.twig',['form' => $builder->createView()]);
    }
    /**
     * @Route("/commande/edit/{id}", name="edit_cmd")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(Request $request, $id) {
        $cmd = new Commande();
        $cmd = $this->getDoctrine()->getRepository(Commande::class)->find($id);

        $form = $this->createForm(cmdType::class,$cmd);


        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $date = new \DateTime();
            $cmd = $form->getData();
            $cmd->setDateCde($date->format('d-m-Y'));
            $cmd->setHeureCde($date->format('H:i:s'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('commande');
        }

        return $this->render('commande/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/commandereset", name="cmd_reset")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function resetcommande (EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Commande::class);
        $entities = $repository->findAll();

        foreach ($entities as $entity) {
            $em->remove($entity);
        }
        $em->flush();
        return $this->redirectToRoute('commande');
    }
}
