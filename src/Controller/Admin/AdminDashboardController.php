<?php

namespace App\Controller\Admin;

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
}
