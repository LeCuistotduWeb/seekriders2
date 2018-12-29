<?php

namespace App\Controller;

use App\Entity\Spot;
use App\Form\SpotType;
use App\Repository\SpotRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SpotController
 * @Route("/spot")
 * @IsGranted("ROLE_USER")
 * @package App\Controller
 */
class SpotController extends AbstractController
{
    /**
     * @Route("/", name="spot_index", methods="GET")
     */
    public function index(SpotRepository $spotRepository): Response
    {
        $spots = $spotRepository->findAll();

        return $this->render('spot/index.html.twig', [
            'spots' => $spots,
        ]);
    }


    /**
     * Permet de créer une annonce
     *
     * @Route("/new", name="spot_new", methods="GET|POST")
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager){
        $spot = new Spot();

        $form = $this->createForm(SpotType::class, $spot);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $spot->setAuthor($this->getUser());

            $manager->persist($spot);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le spot <strong>{$spot->getTitle()}</strong> a bien été enregistré !"
            );

            return $this->redirectToRoute('spot_show', [
                'spot' => $spot,
                'id' => $spot->getId(),
            ]);
        }

        return $this->render('spot/new.html.twig', [
            'form' => $form->createView(),
            'spot' => $spot,
        ]);
    }

    /**
     * @Route("/{id}", name="spot_show", methods="GET")
     */
    public function show(Spot $spot): Response
    {
        return $this->render('spot/show.html.twig', [
            'spot' => $spot,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="spot_edit", methods="GET|POST")
     * @Security("is_granted('ROLE_USER') and user === spot.getAuthor() or is_granted('ROLE_ADMIN') ", message="Vous ne pouvez pas modifier un spot qui ne vous appartient pas.")
     */
    public function edit(Request $request, Spot $spot): Response
    {
        $form = $this->createForm(SpotType::class, $spot);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                "success",
                "Les données du spot ont été modifiés avec succèes !"
            );
            return $this->redirectToRoute('spot_show', ['id'=> $spot->getId()]);
        }

        return $this->render('spot/edit.html.twig', [
            'form' => $form->createView(),
            'spot' => $spot,
        ]);
    }

    /**
     * @Route("/{id}", name="spot_delete", methods="DELETE")
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Spot $spot): Response
    {
        if ($this->isCsrfTokenValid('delete'.$spot->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($spot);
            $em->flush();
        }

        return $this->redirectToRoute('spot_index');
    }
}
