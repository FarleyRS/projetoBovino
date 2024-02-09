<?php

namespace App\Controller;

use App\Entity\Farm;
use App\Form\FarmType;
use App\Repository\FarmRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/farm")
 */
class FarmController extends AbstractController
{
    /**
     * @Route("/", name="app_farm_index", methods={"GET"})
     */
    public function index(FarmRepository $farmRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $farmQuery = $farmRepository->createQueryBuilder('f')
        ->getQuery();

        $farm = $paginator->paginate(
            $farmQuery,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('farm/index.html.twig', [
            'farms' => $farm
        ]);
    }

    /**
     * @Route("/new", name="app_farm_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FarmRepository $farmRepository): Response
    {
        $farm = new Farm();
        $form = $this->createForm(FarmType::class, $farm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $farmRepository->add($farm, true);

            return $this->redirectToRoute('app_farm_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('farm/new.html.twig', [
            'farm' => $farm,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_farm_show", methods={"GET"})
     */
    public function show(Farm $farm): Response
    {
        return $this->render('farm/show.html.twig', [
            'farm' => $farm,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_farm_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Farm $farm, FarmRepository $farmRepository): Response
    {
        $form = $this->createForm(FarmType::class, $farm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $farmRepository->add($farm, true);

            return $this->redirectToRoute('app_farm_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('farm/edit.html.twig', [
            'farm' => $farm,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_farm_delete", methods={"POST"})
     */
    public function delete(Request $request, Farm $farm, FarmRepository $farmRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$farm->getId(), $request->request->get('_token'))) {
            $farmRepository->remove($farm, true);
        }

        return $this->redirectToRoute('app_farm_index', [], Response::HTTP_SEE_OTHER);
    }
}
