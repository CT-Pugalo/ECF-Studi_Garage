<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Garage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $garage = $entityManager->getRepository(Garage::class)->findOneBy(['id' => '1']); 
        $users = $entityManager->getRepository(User::class)->getAll();
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'users' => $users,
            'services' => $garage->getServices(),
        ]);
    }
}
