<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
     * @Route("/", name="user_list", methods="GET|POST")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function list(Request $request, UserRepository $userRepository, PaginatorInterface $paginator): Response
    {

        $users = $paginator->paginate(
            $userRepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            24/*limit per page*/
        );
        return $this->render('user/index.html.twig', ['users' => $users]);
    }

    /**
     * @Route("/{id}", name="user_show", methods="GET")
     * @IsGranted("ROLE_USER")
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', ['user' => $user]);
    }
}