<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     */
    public function login()
    {
        return $this->render('account/login.html.twig', [
        ]);
    }

    /**
     * @Route("/register", name="account_register")
     */
    public function register()
    {
        return $this->render('account/register.html.twig', [
        ]);
    }
}
