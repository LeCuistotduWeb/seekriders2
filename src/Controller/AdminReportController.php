<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminReportController
 * @package App\Controller
 * @Route("/admin")
 */
class AdminReportController extends AbstractController
{
    /**
     * @Route("/report", name="admin_report")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index()
    {
        return $this->render('admin/admin-report.html.twig', [
        ]);
    }
}
