<?php

namespace App\Controller\Admin;

use App\Entity\Spot;
use App\Form\SpotType;
use App\Repository\SpotRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class AdminSpotController
 * @package App\Controller
 * @Route("/admin/spot")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminSpotController extends AbstractController
{
    /**
     * @Route("/", name="admin_spot")
     */
    public function spots(Request $request, PaginatorInterface $paginator, SpotRepository $spotRepository)
    {
        $spots = $paginator->paginate(
            $spotRepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            12/*limit per page*/
        );

        return $this->render('admin/spot/admin-spot.html.twig', [
            'spots'=> $spots,
        ]);
    }

    /**
     * Permet de créer un spot
     *
     * @Route("/new", name="admin_spot_new", methods="GET|POST")
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

        return $this->render('admin/spot/new.html.twig', [
            'form' => $form->createView(),
            'spot' => $spot,
        ]);
    }

    /**
     * @param Spot $spot
     * @return Response
     * @Route("/{id}", name="admin_spot_show", methods="GET")
     */
    public function show(Spot $spot): Response
    {
        return $this->render('admin/spot/show.html.twig', [
            'spot' => $spot,
        ]);
    }

    /**
     * @param Request $request
     * @param Spot $spot
     * @return Response
     * @Route("/{id}/edit", name="admin_spot_edit", methods="GET|POST")
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
            return $this->redirectToRoute('admin_spot', ['id'=> $spot->getId()]);
        }

        return $this->render('admin/spot/edit.html.twig', [
            'form' => $form->createView(),
            'spot' => $spot,
        ]);
    }

    /**
     * @param Request $request
     * @param Spot $spot
     * @return Response
     * @Route("/{id}", name="admin_spot_delete", methods="DELETE")
     */
    public function delete(Request $request, Spot $spot): Response
    {
        if ($this->isCsrfTokenValid('delete'.$spot->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($spot);
            $em->flush();
        }

        return $this->redirectToRoute('admin_spot');
    }
}
