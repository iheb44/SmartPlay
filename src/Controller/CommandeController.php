<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Jouet;
use App\Entity\LigneCde;
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
        $lignecl = $entityManager->getRepository(LigneCde::class)->findBy(['num_cde_ligne' =>$id]);
        foreach ($lignecl as $key => $cmd) {
            $entityManager->remove($cmd);
        }
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
    public function ajouter_cmd(Request $request, EntityManagerInterface $entityManager){
        $cmd = new Commande();
        $ligne_cmd = new LigneCde();
        $builder = $this->createForm(cmdType::class,$cmd);

        $builder->handleRequest($request);

        if($builder->isSubmitted() && $builder->isValid()) {
            $date = new \DateTime();
            $cmd = $builder->getData();
            $jouet = new Jouet();
            $repository = $this->getDoctrine()->getRepository(Jouet::class);

            //dd($cmd);

            $ligne_cmdFrom = $builder->get("ligneCdes")->getData();
            $qte_ligne_cmdFrom = $builder->get("QteLigne")->getData();
            $remiseLigneFrom = $builder->get("remiseLigne")->getData();
            $cmd->setDateCde($date->format('d-m-Y'));
            $cmd->setHeureCde($date->format('H:i:s'));
            $ligne_cmd->setNumCdeLigne($cmd);
            $ligne_cmd->setCodeJoueLigne($ligne_cmdFrom);
            $jouet=$repository->findOneBy(['code_jouet' =>$ligne_cmdFrom] );
            $p=$jouet->getPUJouet();
            $total=($p-($p*$remiseLigneFrom)/100)*$qte_ligne_cmdFrom;
            $cmd->setMntCde($total);
            $ligne_cmd->setQteLigne($qte_ligne_cmdFrom);
            $ligne_cmd->setRemiseLigne($remiseLigneFrom);
            $entityManager->persist($cmd);
            $entityManager->persist($ligne_cmd);
            $entityManager->flush();

            return $this->redirectToRoute('commande');
        }
        return $this->render('commande/new.html.twig',['form' => $builder->createView()]);
    }

    /**
     * @Route("/commande/edit/{id}", name="edit_cmd")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, $id) {
        $ligne_cmd = new LigneCde();
        $cmd = $this->getDoctrine()->getRepository(Commande::class)->find($id);
        $builder = $this->createForm(cmdType::class,$cmd);


        $builder->handleRequest($request);
        if($builder->isSubmitted() && $builder->isValid()) {
            $date = new \DateTime();
            $cmd = $builder->getData();
            $jouet = new Jouet();
            $repository = $this->getDoctrine()->getRepository(Jouet::class);

            //dd($cmd);

            $ligne_cmdFrom = $builder->get("ligneCdes")->getData();
            $qte_ligne_cmdFrom = $builder->get("QteLigne")->getData();
            $remiseLigneFrom = $builder->get("remiseLigne")->getData();
            $cmd->setDateCde($date->format('d-m-Y'));
            $cmd->setHeureCde($date->format('H:i:s'));
            $ligne_cmd->setNumCdeLigne($cmd);
            $ligne_cmd->setCodeJoueLigne($ligne_cmdFrom);
            $jouet=$repository->findOneBy(['code_jouet' =>$ligne_cmdFrom] );
            $p=$jouet->getPUJouet();
            $total=(($p*$remiseLigneFrom)/100)*$qte_ligne_cmdFrom;
            $cmd->setMntCde($total);
            $ligne_cmd->setQteLigne($qte_ligne_cmdFrom);
            $ligne_cmd->setRemiseLigne($remiseLigneFrom);
            $entityManager->persist($cmd);
            $entityManager->persist($ligne_cmd);
            $entityManager->flush();

            return $this->redirectToRoute('commande');
        }

        return $this->render('commande/edit.html.twig', ['form' => $builder->createView()]);
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
