<?php

namespace App\Controller;

use App\Entity\Garage;
use App\Form\HorraireFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GarageController extends AbstractController
{
    #[Route('/horraire', name: 'app_horraire')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        
        $garage = $entityManager->getRepository(Garage::class)->findOneBy(['id' => '1']);
        $horraires = $garage->getHorraires();

        return $this->render('horraire/index.html.twig', [
            'controller_name' => 'GarageController',
            'horraire' => $horraires,
        ]);
    }
    #[Route('/horraire/update', name: 'app_horraire_update')]
    public function update(EntityManagerInterface $entityManager, Request $request): Response
    {
        $garage = $entityManager->getRepository(Garage::class)->findOneBy(['id' => '1']);
        $horraires = $garage->getHorraires();

        $form = $this->createForm(HorraireFormType::class, $garage);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $garage->setOuvertureSemaine($form->get('ouverture_semaine')->getData());
            $garage->setFermetureSemaine($form->get('fermeture_semaine')->getData());

            $garage->setOuvertureSamedi($form->get('ouverture_samedi')->getData());
            $garage->setFermetureSamedi($form->get('fermeture_samedi')->getData());

            $garage->setOuvertureDimanche($form->get('ouverture_dimanche')->getData());
            $garage->setFermetureDimanche($form->get('fermeture_dimanche')->getData());

            $entityManager->persist($garage);
            $entityManager->flush();
            return $this->redirectToRoute('app_horraire');
            
        }

        return $this->render('horraire/update.html.twig', [
            'horraire' => $horraires,
            'form' => $form->createView()
        ]);
    }
}
