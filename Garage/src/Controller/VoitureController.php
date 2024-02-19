<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Entity\Temoignage;
use App\Form\VoitureCreatingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoitureController extends AbstractController
{
    #[Route('/voiture/register', name: 'app_voiture_register')]
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {

        $voiture = new Voiture();
        $form = $this->createForm(VoitureCreatingType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $voiture->setNom($form->get('nom')->getData());
            $voiture->setPrix($form->get('prix')->getData());
            $voiture->setKilometrage($form->get('kilometrage')->getData());
            $voiture->setAnneeCirculation($form->get('annee_circulation')->getData());
            $voiture->setImage($form->get('image')->getData());

            $entityManager->persist($voiture);
            $entityManager->flush();
            return $this->redirectToRoute('app_test');
        }


        return $this->render('voiture/register.html.twig', [
            'voitureCreating' => $form->createView(),
        ]);
    }

    #[Route('/voiture', name: 'app_voiture')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $cars = $entityManager->getRepository(Voiture::class)->getAll();

        $maxKm = $entityManager->getRepository(Voiture::class)->getMaxKm();
        $minKm = $entityManager->getRepository(Voiture::class)->getMinKm();

        $maxPrix = $entityManager->getRepository(Voiture::class)->getMaxPrix();
        $minPrix = $entityManager->getRepository(Voiture::class)->getMinPrix();

        $maxAnnee = $entityManager->getRepository(Voiture::class)->getMaxAnnee();
        $minAnnee = $entityManager->getRepository(Voiture::class)->getMinAnnee();

        return $this->render('voiture/index.html.twig', [
            'cars' => $cars,
            'max_km' => $maxKm,
            'min_km' => $minKm,
            'max_prix' => $maxPrix,
            'min_prix' => $minPrix,
            'max_annee' => $maxAnnee,
            'min_annee' => $minAnnee,
        ]);
    }
}
