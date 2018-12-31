<?php

namespace App\Controller;

use App\Repository\SpotRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(SpotRepository $spotRepository, UserRepository $userRepository)
    {
        $spots = $spotRepository->findLastSpotsCreatedWidthLimit(3);
        $users = $userRepository->findLastUsersCreatedWidthLimit(8);
        return $this->render('home/home.html.twig', [
            'spots' => $spots,
            'users' => $users,
        ]);
    }
}
