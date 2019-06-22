<?php

namespace App\Notification;
use Twig\Environment;

/**
 *
 */
class ContactNotification
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $render;

    /**
     * ContactNotification constructor.
     * @param \Swift_Mailer $mailer
     * @param \Twig_Environment $render
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $render)
    {
        $this->mailer = $mailer;
        $this->render = $render;
    }

    /**
     * Send contact mail
     */
    public function sendMail($data){
        $message = (new \Swift_Message('Contact Seekriders'))
            ->setFrom(['noreply@seekriders.fr' => 'Seekriders'])
            ->setTo(['contact@gaetanboyron.fr' => 'Seekriders'])
            ->setBody($this->render->render('emails/contactNotification.html.twig', [
                'data' => $data,
            ]))
        ;
        $this->mailer->send($message);
        return true;
    }
}
