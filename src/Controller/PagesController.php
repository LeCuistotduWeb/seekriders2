<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function contact(Request $request, ContactNotification $notification)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isSubmitted()){

            if($notification->sendMail($form->getData()))
            {
                $this->addFlash(
                    "success",
                    "Votre message a bien été envoyé !"
                );
            }else{
                $this->addFlash(
                    "danger",
                    "Une erreur est survenu, veuillez rééssayer plus tard."
                );
            }
            $this->redirectToRoute('home');
        }

        return $this->render('pages/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
