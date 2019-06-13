<?php

namespace App\Controller;

use App\Entity\Spot;
use App\Entity\SpotSearch;
use App\Form\SearchSpotType;
use App\Form\SpotSearchType;
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
     * @Route("/", name="spot_index", methods="GET|POST")
     */
    public function index(): Response
    {
        $search = new SpotSearch();
        $form = $this->createForm(SpotSearchType::class, $search);
        return $this->render('spot/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet de créer une annonce
     *
     * @Route("/new", name="spot_new", methods="GET|POST")
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
     * @Route("/{id}", name="spot_show", requirements={"id"="\d+"}, methods="GET")
     * @IsGranted("ROLE_USER")
     */
    public function show(Spot $spot): Response
    {
        return $this->render('spot/show.html.twig', [
            'spot' => $spot,
            'spotJson' => json_encode($spot->toArray()),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="spot_edit", requirements={"id"="\d+"}, methods="GET|POST")
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
     * @Route("/favorites", name="spots_favorites",)
     */
    public function favorites(SpotRepository $spotRepository){
        $spots = $spotRepository->findAll();
        $favorites = [];
        foreach( $spots as $spot){
            if ($spot->isLikeByUser($this->getUser())){
                $favorites[] = $spot;
            }
        }

        return $this->render('spot/favorites.html.twig', [
            'spots' => $favorites
        ]);
    }
}
