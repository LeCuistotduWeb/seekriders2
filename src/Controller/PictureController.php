<?php

namespace App\Controller;

use App\Entity\SpotPicture;
use App\Entity\User;
use App\Entity\UserPicture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PictureController extends AbstractController
{
    /**
     * @Route("/spot/picture/{id}", name="spot_picture_delete", methods="DELETE")
     */
    public function spotPictureDelete(SpotPicture $picture, Request $request) {
        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete' . $picture->getId(), $data['_token'])) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($picture);
            $em->flush();
            return new JsonResponse(['success' => 1]);
        }

        return new JsonResponse(['error' => 'Token invalide'], 400);
    }

    /**
     * @Route("/user/avatar/{id}", name="user_picture_delete", methods="DELETE")
     */
    public function userPictureDelete(User $user, Request $request, EntityManagerInterface $manager) {
        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $data['_token'])) {
            $user->setAvatar(null);
            $manager->persist($user);
            $manager->flush();
            return new JsonResponse(['success' => 1]);
        }

        return new JsonResponse(['error' => 'Token invalide'], 400);
    }
}
