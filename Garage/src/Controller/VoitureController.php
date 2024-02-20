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

use function PHPUnit\Framework\isEmpty;

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
    #[Route('/voiture/update', name: 'app_voiture_update')]
    public function update(Request $request, EntityManagerInterface $entityManager): Response
    {
        $voiture = new Voiture();
        if($_GET['carID'] && isset($_GET['carID'])){
            $voiture=$entityManager->getRepository(Voiture::class)->findOneBy(['id' => $_GET['carID']]);
        }
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

    #[Route('/voiture/delete', name: 'app_voiture_delete')]
    public function delete(Request $request, EntityManagerInterface $entityManager): Response
    {
        $voiture = new Voiture();
        if($_GET['carID'] && isset($_GET['carID'])){
            $voiture=$entityManager->getRepository(Voiture::class)->findOneBy(['id' => $_GET['carID']]);
        }
        $form = $this->createForm(VoitureCreatingType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $entityManager->remove($voiture);
            $entityManager->flush();
            return $this->redirectToRoute('app_test');
            
        }
        return $this->render('voiture/supprimer.html.twig', [
            'form' => $form->createView(),
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

        if(!empty($maxKm)){
            $maxKm=$maxKm[0]["kilometrage"];
        }else{ $maxKm=0; }
        if(!empty($minKm)){
            $minKm=$minKm[0]["kilometrage"];
        }else{ $minKm=0; }

        if(!empty($maxPrix)){
            $maxPrix=$maxPrix[0]["prix"];
        }else{ $maxPrix=0; }
        if(!empty($minPrix)){
            $minPrix=$minPrix[0]["prix"];
        }else{ $minPrix=0; }

        if(!empty($maxAnnee)){
            $maxAnnee=$maxAnnee[0]["annee_circulation"]->format('Y');
        }else{ $maxAnnee=""; }
        if(!empty($minAnnee)){
            $minAnnee=$minAnnee[0]["annee_circulation"]->format('Y');
        }else{ $minAnnee=""; }

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
