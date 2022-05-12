<?php

namespace App\Controller;

use App\Entity\Pfe;
use App\Form\PfeType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PfeController extends AbstractController
{

    #[Route('/pfe/add', name: 'add_pfe')]
    public function add(EntityManagerInterface $manager,Request $request): Response
    {
        $pfe=new Pfe();
        $form=$this->createForm(PfeType::class,$pfe);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
            $manager->persist($pfe);
            $manager->flush();


            return $this->render('pfe/detail.html.twig',
                ['pfe' => $pfe]);

        }
        else{

            return $this->render('pfe/index.html.twig', [
                'form' => $form->createView()]) ;
        }

    }
    #[Route('/pfe', name: 'pfe.all')]
    public function index(ManagerRegistry $doctrine): Response{
        $repository = $doctrine->getRepository(Pfe::class);
        $pfes=$repository->findAll();
        return $this->render('pfe/all.html.twig', [
            'pfes' => $pfes,
        ]);
    }

    #[Route('/pfe/stats', name: 'pfe.stats')]
    public function stats(ManagerRegistry $doctrine,): Response {
        $repo = $doctrine->getRepository(PFE::class);
        $stats = $repo->stats();

        return $this->render('pfe/stats.html.twig', [
            'stats' => $stats
        ]);
    }

}
