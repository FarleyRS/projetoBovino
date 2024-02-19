<?php

namespace App\Controller;

use App\Entity\Cow;
use App\Form\CowType;
use App\Repository\CowRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cow")
 */
class CowController extends AbstractController
{
    /**
     * @Route("/", name="app_cow_index", methods={"GET"})
     */
    public function index(CowRepository $cowRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $cowsQuery = $cowRepository->createQueryBuilder('c')
            ->getQuery();

        $cows = $paginator->paginate(
            $cowsQuery,
            $request->query->getInt('page', 1),
            10 // Número de itens por página
        );

        return $this->render('cow/index.html.twig', [
            'cows' => $cows,
        ]);
    }

    /**
     * @Route("/new", name="app_cow_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CowRepository $cowRepository): Response
    {
        $cow = new Cow();
        $cow->setStatus(true);
        $form = $this->createForm(CowType::class, $cow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $cowRepository->add($cow, true);
                $this->addFlash('success', 'Animal Adicionado com sucesso.');
                return $this->redirectToRoute('app_cow_index', [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erro ao adicionar novo animal');
                return $this->redirectToRoute('app_cow_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('cow/new.html.twig', [
            'cow' => $cow,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}", name="app_cow_show", methods={"GET"})
     */
    public function show(Cow $cow): Response
    {
        return $this->render('cow/show.html.twig', [
            'cow' => $cow,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_cow_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Cow $cow, CowRepository $cowRepository): Response
    {

        $form = $this->createForm(CowType::class, $cow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $cowRepository->add($cow, true);
                $this->addFlash('success', 'Animal editado com sucesso.');
                return $this->redirectToRoute('app_cow_index', [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Não foi possivel editar');
            }
        }

        return $this->renderForm('cow/edit.html.twig', [
            'cow' => $cow,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_cow_delete", methods={"POST"})
     */
    public function delete($id, Request $request, CowRepository $cowRepository): Response
    {
        $cow = $cowRepository->find($id);

        if (!$cow) {
            $this->addFlash('error', 'Animal não encontrado.');
            return $this->redirectToRoute('app_cow_index', [], Response::HTTP_SEE_OTHER);
        }

        try {
            if ($this->isCsrfTokenValid('delete' . $cow->getId(), $request->request->get('_token'))) {
                $cowRepository->remove($cow, true);
                $this->addFlash('success', 'Animal deletado com sucesso.');
            }
        } catch (\Exception $e) {
            $this->addFlash('error', 'Não foi possivel deletar o animal com Codigo: ' . $cow->getCodigo());
        }

        return $this->redirectToRoute('app_cow_index');
    }
}
