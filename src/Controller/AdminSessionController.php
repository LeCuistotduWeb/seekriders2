<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminSessionController
 * @package App\Controller
 * @Route("/admin/session")
 */
class AdminSessionController extends AbstractController
{
    /**
     * @Route("/", name="admin_session")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index()
    {
        return $this->render('admin/session/admin-session.html.twig', [
        ]);
    }
}
