<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PagesController extends AbstractController
{
    /**
     * @Route("/privacy", name="privacy")
     */
    public function privacy()
    {
        return $this->render('pages/privacy.html.twig', []);
    }
    
    /**
     * @Route("/terms", name="terms")
     */
    public function terms()
    {
        return $this->render('pages/terms.html.twig', []);
    }
    
    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('pages/contact.html.twig', []);
    }
}
