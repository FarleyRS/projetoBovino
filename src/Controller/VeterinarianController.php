<?php

namespace App\Controller;

use App\Entity\Veterinarian;
use App\Form\VeterinarianType;
use App\Repository\VeterinarianRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/veterinarian")
 */
class VeterinarianController extends AbstractController
{
    /**
     * @Route("/", name="app_veterinarian_index", methods={"GET"})
     */
    public function index(VeterinarianRepository $vetRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $vetQuery = $vetRepository->createQueryBuilder('c')
            ->getQuery();

        $veterinarians = $paginator->paginate(
            $vetQuery,
            $request->query->getInt('page', 1),
            10 // Número de itens por página
        );

        return $this->render('veterinarian/index.html.twig', [
            'veterinarians' => $veterinarians,
        ]);
    }

    /**
     * @Route("/new", name="app_veterinarian_new", methods={"GET", "POST"})
     */
    public function new(Request $request, VeterinarianRepository $veterinarianRepository): Response
    {
        $veterinarian = new Veterinarian();
        $form = $this->createForm(VeterinarianType::class, $veterinarian);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $veterinarianRepository->add($veterinarian, true);

            return $this->redirectToRoute('app_veterinarian_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('veterinarian/new.html.twig', [
            'veterinarian' => $veterinarian,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_veterinarian_show", methods={"GET"})
     */
    public function show(Veterinarian $veterinarian): Response
    {
        return $this->render('veterinarian/show.html.twig', [
            'veterinarian' => $veterinarian,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_veterinarian_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Veterinarian $veterinarian, VeterinarianRepository $veterinarianRepository): Response
    {
        $form = $this->createForm(VeterinarianType::class, $veterinarian);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $veterinarianRepository->add($veterinarian, true);

            return $this->redirectToRoute('app_veterinarian_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('veterinarian/edit.html.twig', [
            'veterinarian' => $veterinarian,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_veterinarian_delete", methods={"POST"})
     */
    public function delete(Request $request, Veterinarian $veterinarian, VeterinarianRepository $veterinarianRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$veterinarian->getId(), $request->request->get('_token'))) {
            $veterinarianRepository->remove($veterinarian, true);
        }

        return $this->redirectToRoute('app_veterinarian_index', [], Response::HTTP_SEE_OTHER);
    }
}
