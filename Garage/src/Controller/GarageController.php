<?php

namespace App\Controller;

use App\Entity\Garage;
use App\Entity\Voiture;
use App\Form\ContactType;
use App\Form\HorraireFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class GarageController extends AbstractController
{
    #[Route('/horraire', name: 'app_horraire')]
    public function horraire(EntityManagerInterface $entityManager): Response
    {
        
        $garage = $entityManager->getRepository(Garage::class)->findOneBy(['id' => '1']);
        $horraires = $garage->getHorraires();

        return $this->render('horraire/index.html.twig', [
            'controller_name' => 'GarageController',
            'horraire' => $horraires,
        ]);
    }
    #[Route('/horraire/update', name: 'app_horraire_update')]
    public function updateHorraire(EntityManagerInterface $entityManager, Request $request): Response
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

    #[Route('/contact', name: 'app_contact')]
    public function contact(EntityManagerInterface $entityManager, Request $request){

        $message="";
        $flag=-1;
        $carID=-1;
        $serviceID=-1;

        $car=new Voiture();

        if(isset($_GET['flag']) && $_GET['flag']){
            $flag=$_GET['flag'];
        }
        if(isset($_GET['carID']) && $_GET['carID']){
            $carID=$_GET['carID'];
        }
        if($carID!=-1){
            $car=$entityManager->getRepository(Voiture::class)->findOneBy(['id'=>$carID]);
        }

        $garage = $entityManager->getRepository(Garage::class)->findOneBy(['id' => '1']); 
        $form = $this->createForm(ContactType::class, $garage);
        $form->handleRequest($request);
        $transport = Transport::fromDsn('smtp://homeserver:25?encryption=&auth_mode=&verify_peer=0');
        $mailer = new Mailer($transport);

        if($form->isSubmitted() && $form->isValid()){
            $email = (new Email())
                ->to($form->get('contact_mail')->getData())
                ->from($form->get('mail')->getData())
                ->subject("Demande d'info")
                ->text($form->get('message')->getData());
            $mailer->send($email);
            return $this->redirectToRoute('app_test');
        }
        if($flag == "1" && $car!=null){
            $message = "J'aimerais plus d'info sur la voiture ".$car->getId()." ".$car->getNom()." anonce a ".$car->getPrix()."E";
        }

        return $this->render('contact/contact.html.twig',[
            'form'=>$form->createView(),
            'message'=>$message,
        ]);
    }
}
