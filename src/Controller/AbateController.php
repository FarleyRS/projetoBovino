<?php

// AbateController.php

namespace App\Controller;

use App\Entity\Cow;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class AbateController extends AbstractController
{
    /**
     * @Route("/relatorio-abate", name="app_relatorio_abate")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $queryBuilder = $entityManager->getRepository(Cow::class)->findGadosParaAbate();

        $relatorioAbate = $paginator->paginate(
            $queryBuilder->getQuery(),
            $request->query->getInt('page', 1),
            10 
        );

        return $this->render('abate/index.html.twig', ['relatorioAbate' => $relatorioAbate]);
    }

    /**
     * @Route("/enviar-abate/{codigo}", name="app_enviar_abate", methods={"POST"})
     */
    public function enviarAbate($codigo): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        // Lógica para enviar o animal para o abate
        $animal = $entityManager->getRepository(Cow::class)->findOneBy(['codigo' => $codigo]);
        $animal->setStatus(false);
        $entityManager->flush();

        $this->addFlash('success', 'Animal enviado para abate com sucesso.');

        return $this->redirectToRoute('app_relatorio_abate');
    }
}
