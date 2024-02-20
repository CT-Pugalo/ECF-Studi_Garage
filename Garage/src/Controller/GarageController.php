<?php

namespace App\Controller;

use App\Entity\Garage;
use App\Entity\Service;
use App\Entity\Voiture;
use App\Form\ContactType;
use App\Form\HorraireFormType;
use App\Form\ServiceType;
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

    #[Route('/services', name:'app_service')]
    public function services(EntityManagerInterface $entityManager): Response{
        $garage = $entityManager->getRepository(Garage::class)->findOneBy(['id' => '1']); 
        return $this->render('services/services.html.twig',[
            'services' => $garage->getServices(),
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(EntityManagerInterface $entityManager, Request $request): Response{

        $message="";
        $flag=-1;
        $carID=-1;
        $serviceID=-1;

        $car=new Voiture();
        $service=new Service();

        if(isset($_GET['flag']) && $_GET['flag']){
            $flag=$_GET['flag'];
        }
        if(isset($_GET['carID']) && $_GET['carID']){
            $carID=$_GET['carID'];
        }
        if(isset($_GET['serviceID']) && $_GET['serviceID']){
            $serviceID=$_GET['serviceID'];
        }
        if($carID!=-1){
            $car=$entityManager->getRepository(Voiture::class)->findOneBy(['id'=>$carID]);
        }
        if($serviceID!=-1){
            $service=$entityManager->getRepository(Service::class)->findOneBy(['id'=>$serviceID]);
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
            $message = "J'aimerais plus d'info sur la voiture ".$car->getNom()." anonce a ".$car->getPrix()."E";
        }
        if($flag == "2" && $service!=null){
            $message = "J'aimerais plus d'info sur le service ".$service->getNom();
        }
        $_GET=null;
        return $this->render('contact/contact.html.twig',[
            'form'=>$form->createView(),
            'message'=>$message,
        ]);
    }

    #[Route('/services/ajouter', name:'app_service_add')]
    public function ajouterService(EntityManagerInterface $entityManager, Request $request): Response
    {
        $service=new Service();
        $garage = $entityManager->getRepository(Garage::class)->findOneBy(['id' => '1']); 
        $form=$this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $service->setGarage($garage);
            $service->setNom($form->get('Nom')->getData());
            $service->setDescription($form->get('Description')->getData());

            $entityManager->persist($service);
            $entityManager->flush();
            return $this->redirectToRoute('app_service');
        }

        return $this->render('services/ajouter.html.twig', [
            'form'=>$form->createView(),
        ]);
    }
    #[Route('/services/update', name:'app_service_update')]
    public function updateService(EntityManagerInterface $entityManager, Request $request): Response
    {
        if($_GET['serviceID'] && isset($_GET['serviceID'])){
            $service=$entityManager->getRepository(Service::class)->findOneBy(['id' => $_GET['serviceID']]);
        }
        $garage = $entityManager->getRepository(Garage::class)->findOneBy(['id' => '1']); 
        $form=$this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $service->setGarage($garage);
            $service->setNom($form->get('Nom')->getData());
            $service->setDescription($form->get('Description')->getData());

            $entityManager->persist($service);
            $entityManager->flush();
            return $this->redirectToRoute('app_service');
        }

        return $this->render('services/ajouter.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    #[Route('/services/delete', name:'app_service_remove')]
    public function deleteService(EntityManagerInterface $entityManager, Request $request): Response
    {
        if($_GET['serviceID'] && isset($_GET['serviceID'])){
            $service=$entityManager->getRepository(Service::class)->findOneBy(['id' => $_GET['serviceID']]);
        }
        $form=$this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->remove($service);
            $entityManager->flush();
            return $this->redirectToRoute('app_service');
        }
        return $this->render('services/supprimer.html.twig', [
            'form'=>$form->createView(),
        ]);
    }
}
