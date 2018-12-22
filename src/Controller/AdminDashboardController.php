<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminDashboardController
 * @package App\Controller
 */
class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index()
    {
        return $this->render('admin_dashboard/index.html.twig', [
            'controller_name' => 'AdminDashboardController',
        ]);
    }
}
