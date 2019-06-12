<?php

namespace App\Controller\Api;

use App\Entity\Spot;
use App\Entity\SpotLike;
use App\Form\SearchSpotType;
use App\Repository\SpotLikeRepository;
use App\Repository\SpotRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiSpotController
 * @Route("/api/spots")
 * @IsGranted("ROLE_USER")
 * @package App\Controller
 */
class ApiSpotController extends AbstractController
{
    /**
     * @Route("/", name="api_spots_all",)
     */
    public function allSpots(Request $request, SpotRepository $spotRepository){
        $spots = $spotRepository->findall();
        $newArray = [];

        foreach($spots as $spot)
        {
            $newArray[] = $spot->toArray();
        }
        return new JsonResponse($newArray);
    }

    /**
     * Permet de liker un spot
     * @Route("/{id}/like", name="api_spot_like", requirements={"id"="\d+"})
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
}
