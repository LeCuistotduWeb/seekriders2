<?php

namespace App\Controller;

use App\Repository\SpotRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminDashboardController
 * @package App\Controller
 * @Route("/admin")
 */
class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/", name="admin_dashboard")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(SpotRepository $spotRepository, UserRepository $userRepository)
    {
        return $this->render('admin/admin-dashboard.html.twig', [
            'spots'=> $spotRepository->findAll(),
            'users'=> $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/spots", name="admin_spots")
     * @IsGranted("ROLE_ADMIN")
     */
    public function spots(SpotRepository $spotRepository)
    {
        return $this->render('admin/admin-spots.html.twig', [
            'spots'=> $spotRepository->findAll(),
        ]);
    }

    /**
     * @Route("/sessions", name="admin_sessions")
     * @IsGranted("ROLE_ADMIN")
     */
    public function sessions()
    {
        return $this->render('admin/admin-sessions.html.twig', [
        ]);
    }

    /**
     * @Route("/users", name="admin_users")
     * @IsGranted("ROLE_ADMIN")
     */
    public function users(UserRepository $userRepository)
    {
        return $this->render('admin/admin-users.html.twig', [
            'users'=> $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/reports", name="admin_reports")
     * @IsGranted("ROLE_ADMIN")
     */
    public function reports(UserRepository $userRepository)
    {
        return $this->render('admin/admin-reports.html.twig', [
        ]);
    }
}
