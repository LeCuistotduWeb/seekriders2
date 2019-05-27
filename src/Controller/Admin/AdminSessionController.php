<?php

namespace App\Controller\Admin;

use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminSessionController
 * @package App\Controller
 * @Route("/admin/session")
 */
class AdminSessionController extends AbstractController
{
    /**
     * Permet d'afficher la liste des sessions
     *
     * @Route("/", name="admin_session")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(Request $request, PaginatorInterface $paginator, SessionRepository $sessionRepository)
    {
        $sessions = $paginator->paginate(
            $sessionRepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            12/*limit per page*/
        );

        return $this->render('admin/session/admin-session.html.twig', [
            'sessions'=> $sessions,
        ]);
    }

    /**
     * Permet de créer une session
     *
     * @Route("/new", name="admin_session_new", methods="GET|POST")
     * @IsGranted("ROLE_ADMIN")
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager): Response
    {
        $session = new Session();

        $form = $this->createForm(SessionType::class, $session);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $session->setAuthor($this->getUser());

            $manager->persist($session);
            $manager->flush();

            $this->addFlash('success', "La session <strong>{$session->getTitle()}</strong> a bien été enregistrée !");

            return $this->redirectToRoute('admin_session_show', [
                'session' => $session,
                'id' => $session->getId(),
            ]);
        }

        return $this->render('admin/session/new.html.twig', [
            'form' => $form->createView(),
            'session' => $session,
        ]);
    }

    /**
     * Permet d'afficher une session
     *
     * @param Session $session
     * @return Response
     * @Route("/{id}", name="admin_session_show", methods="GET")
     * @IsGranted("ROLE_ADMIN")
     */
    public function show(Session $session): Response
    {
        return $this->render('admin/session/show.html.twig', [
            'session' => $session,
        ]);
    }

    /**
     * Permet d'editer une session
     *
     * @param Request $request
     * @param Session $session
     * @return Response
     * @Route("/{id}/edit", name="admin_session_edit", methods="GET|POST")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Session $session): Response
    {
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                "success",
                "Les données du spot ont été modifiés avec succèes !"
            );
            return $this->redirectToRoute('admin_session', ['id'=> $session->getId()]);
        }

        return $this->render('admin/session/edit.html.twig', [
            'form' => $form->createView(),
            'session' => $session,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_session_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Session $session): Response
    {
        if ($this->isCsrfTokenValid('delete'.$session->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($session);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_session');
    }
}
