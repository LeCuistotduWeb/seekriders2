<?php

namespace App\Controller;

use App\Entity\Spot;
use App\Entity\SpotLike;
use App\Entity\SpotSearch;
use App\Form\SearchSpotType;
use App\Form\SpotSearchType;
use App\Form\SpotType;
use App\Repository\SpotLikeRepository;
use App\Repository\SpotRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * Permet de liker un spot
     * @Route("/{id}/like", name="spot_like", requirements={"id"="\d+"})
     */
    public function like(Spot $spot, ObjectManager $manager, SpotLikeRepository $spotLikeRepository): Response
    {
        $user = $this->getUser();

        if(!$user) return $this->json([
            'code' => 403,
            'message' => 'Unauthorize'
        ], 403);

        if ($spot->isLikeByUser($user)){
            $like = $spotLikeRepository->findOneBy([
                'spot' => $spot,
                'user' => $user
            ]);
            $manager->remove($like);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'like bien supprimé',
                'likes' => $spotLikeRepository->count(['spot' => $spot])
            ], 200);
        }

        $like = new SpotLike();
        $like->setSpot($spot)
            ->setUser($user);
        $manager->persist($like);
        $manager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'tout es ok',
            'likes' => $spotLikeRepository->count(['spot' => $spot])
        ], 200);
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

    /**
     * @Route("/api/all", name="spots_all_api",)
     */
    public function allSpot(SpotRepository $spotRepository){
        $spots = $spotRepository->findall();
        $newArray = [];

        foreach($spots as $spot)
        {
            $newArray[] = $spot->toArray();
        }
        return new JsonResponse($newArray);
    }
}
