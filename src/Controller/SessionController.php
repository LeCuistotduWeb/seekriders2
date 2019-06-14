<?php

namespace App\Controller;

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
 * @Route("/session")
 * @IsGranted("ROLE_USER")
 */
class SessionController extends AbstractController
{
    /**
     * @Route("/", name="session_index", methods={"GET"})
     */
    public function index(SessionRepository $sessionRepository): Response
    {
        return $this->render('session/index.html.twig', [
            'sessions' => $sessionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="session_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $session = new Session();
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $session->setAuthor($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('session_index');
        }

        return $this->render('session/new.html.twig', [
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/my-sessions", name="session_my_sessions", methods="GET")
     * @IsGranted("ROLE_USER")
     */
    public function mySessions(SessionRepository $sessionRepository): Response
    {
        $sessionsList = $sessionRepository->findAll();
        $sessions = [];
        foreach ($sessionsList as $session){
            if($session->isParticipating($this->getUser())){
                $sessions[] = $session;
            }
        }
        return $this->render('session/my_session.html.twig', ['sessions' => $sessions]);
    }

    /**
     * @Route("/{id}", name="session_show", methods={"GET"}, requirements={"\d+"})
     */
    public function show(Session $session): Response
    {
        dump(json_encode($session->getSpot()->toArray()));
        return $this->render('session/show.html.twig', [
            'session' => $session,
            'spot' => json_encode($session->getSpot()->toArray()),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="session_edit", methods={"GET","POST"}, requirements={"\d+"})
     * @Security("is_granted('ROLE_USER') and user === session.getAuthor() or is_granted('ROLE_ADMIN') ", message="Vous ne pouvez pas modifier une session qui ne vous appartient pas.")
     */
    public function edit(Request $request, Session $session): Response
    {
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('session_show', [
                'id' => $session->getId(),
            ]);
        }

        return $this->render('session/edit.html.twig', [
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="session_delete", methods={"DELETE"}, requirements={"\d+"})
     * @Security("is_granted('ROLE_USER') and user === session.getAuthor() or is_granted('ROLE_ADMIN') ", message="Vous ne pouvez pas supprimer une session qui ne vous appartient pas.")
     */
    public function delete(Request $request, Session $session): Response
    {
        if ($this->isCsrfTokenValid('delete'.$session->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($session);
            $entityManager->flush();
        }

        return $this->redirectToRoute('session_index');
    }
}
