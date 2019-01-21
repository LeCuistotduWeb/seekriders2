<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GoogleController extends AbstractController
{
    /**
     * @Route("/google", name="google")
     */
    public function index()
    {
        return $this->render('google/admin-dashboard.html.twig', [
            'controller_name' => 'GoogleController',
        ]);
    }
}
