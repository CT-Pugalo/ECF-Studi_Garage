<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Voiture;
use App\Entity\Temoignage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager->getRepository(User::class)->getAll();
        $cars = $entityManager->getRepository(Voiture::class)->getAll();
        $temoignages = $entityManager->getRepository(Temoignage::class)->getAll();

        return $this->render('test/index.html.twig', [
            'users' => $users,
            'cars' => $cars,
            'temoignages' => $temoignages,
        ]);
    }
}
