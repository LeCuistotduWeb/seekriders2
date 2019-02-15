<?php

namespace App\Controller;

use App\Entity\Friendship;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/{id}", name="user_show", methods="GET")
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/addfriend/{id}", name="user_add_friend", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function addFriend(Request $request, UserRepository $userRepository, $id, ObjectManager $manager) :Response
    {
        $user = $this->getUser();
        $friend = $userRepository->find($id);

        $friendship = new Friendship();
        $friendship->setUser1($user);
        $friendship->setUser2($friend);

        $manager->persist($friendship);
        $manager->flush();

        return $this->redirectToRoute('user_show', ['id' => $id]);
    }
}
