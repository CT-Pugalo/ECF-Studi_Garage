<?php

namespace App\Controller;

use App\Entity\Temoignage;
use App\Form\TemoignageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TemoignageController extends AbstractController
{
    #[Route('/temoignage', name: 'app_temoignage')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $temoignages = $entityManager->getRepository(Temoignage::class)->getAll();
        return $this->render('temoignage/index.html.twig', [
            'temoignages' => $temoignages,
        ]);
    }
    #[Route('/temoignage/create', name: 'app_temoignage_register')]
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $temoignage = new Temoignage();
        $form = $this->createForm(TemoignageType::class, $temoignage);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $temoignage->setCommentaire($form->get('commentaire')->getData());
            $temoignage->setNote($form->get('note')->getData());
            $temoignage->setUserid($form->get('userid')->getData());
            $temoignage->setTitre($form->get('titre')->getData());

            $entityManager->persist($temoignage);
            $entityManager->flush();
            return $this->redirectToRoute('app_temoignage');
        }

        return $this->render('temoignage/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
