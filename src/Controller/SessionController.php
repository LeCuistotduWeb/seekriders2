<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\SessionSearch;
use App\Form\SessionSearchType;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use App\Repository\SpotRepository;
use Knp\Component\Pager\PaginatorInterface;
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
     * @Route("/", name="session_index", methods={"GET","POST"})
     */
    public function index(Request $request, SessionRepository $sessionRepository, PaginatorInterface $paginator): Response
    {
        $search = new SessionSearch();
        $search->setStartDateAt(new \DateTime('now'));
        $search->setEndDateAt(new \DateTime('1 month'));

        $form = $this->createForm(SessionSearchType::class, $search);

        $form->handleRequest($request);

        $sessionsList = $sessionRepository->findSessionsNotDone();

        if ($form->isSubmitted() && $form->isValid()) {
            $sessionsList = $sessionRepository->findSessionsWidthOptions($search);
        }

        $sessions = $paginator->paginate(
            $sessionsList, /* query NOT result */
            $request->query->getInt('page', 1),/*page number*/
            6/*limit per page*/
        );

        return $this->render('session/index.html.twig', [
            'sessions' => $sessions,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="session_new", methods={"GET","POST"})
     */
    public function new(Request $request, SpotRepository $spotRepository): Response
    {
        $session = new Session();
        $session->setStartDateAt(new \DateTime());
        $session->setEndDateAt($session->getStartDateAt());
        if($request->query->get('spot')){
            $spot = $spotRepository->find($request->query->get('spot'));
            $session->setSpot($spot);
        }
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $session->setAuthor($this->getUser());
            $session->addParticipant($this->getUser());
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
