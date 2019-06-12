<?php

namespace App\Controller\Api;

use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/session")
 * @IsGranted("ROLE_USER")
 */
class ApiSessionController extends AbstractController
{
    /**
     * Ajoute ou retire un participant d'une session
     * @Route("/{id}/participant", name="api_session_participant", requirements={"id"="\d+"})
     */
    public function addParticipant(Session $session, ObjectManager $manager, SessionRepository $sessionRepository)
    {
        $user = $this->getUser();

        if(!$user) return $this->json([
            'code' => 403,
            'message' => 'Unauthorize'
        ], 403);

        if ($session->isParticipating($user)){
            $session->removeParticipant($user);
            $manager->flush();
            return $this->json([
                'code' => 200,
                'message' => 'Participant bien retiré',
            ], 200);
        }

        $session->addParticipant($user);
        $manager->flush();
        return $this->json([
            'code' => 200,
            'message' => 'Participant bien ajouté',
        ], 200);
    }
}
