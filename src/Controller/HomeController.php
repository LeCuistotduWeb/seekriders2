<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use App\Repository\SpotRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(SpotRepository $spotRepository, UserRepository $userRepository, SessionRepository $sessionRepository)
    {
        $spots = $spotRepository->findLastSpotsCreatedWidthLimit(3);
        $users = $userRepository->findLastUsersCreatedWidthLimit(8);
        $sessions = $sessionRepository->findLastSessionsCreatedWidthLimit(4);
        return $this->render('home/home.html.twig', [
            'spots' => $spots,
            'users' => $users,
            'sessions' => $sessions,
        ]);
    }
}
