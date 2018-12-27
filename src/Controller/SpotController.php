<?php

namespace App\Controller;

use App\Entity\Spot;
use App\Form\SpotType;
use App\Repository\SpotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SpotController
 * @Route("/spot")
 * @package App\Controller
 */
class SpotController extends AbstractController
{
    /**
     * @Route("/", name="spot")
     */
    public function index(SpotRepository $spotRepository)
    {
        $spots = $spotRepository->findAll();

        return $this->render('spot/index.html.twig', [
            'spots' => $spots,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="spot_edit")
     */
    public function edit(Request $request, Spot $spot)
    {
        $form = $this->createForm(SpotType::class, $spot);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                "success",
                "Les données du spot ont été modifiés avec succèes !"
            );
//            return $this->redirectToRoute('spot_show');
        }

        return $this->render('spot/edit.html.twig', [
            'form' => $form->createView(),
            'spot' => $spot,
        ]);
    }

    /**
     * @Route("/{id}", name="spot_show")
     */
    public function show(Spot $spot)
    {
        return $this->render('spot/show.html.twig', [
            'spot' => $spot,
        ]);
    }
}
