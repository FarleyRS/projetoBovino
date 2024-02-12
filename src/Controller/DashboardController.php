<?php

namespace App\Controller;

use App\Entity\Cow;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/ ", name="app_dashboard")
     */
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $relatorioLeite = $entityManager->getRepository(Cow::class)->findQuantidadeTotalLeite();
        $relatorioRacao = $entityManager->getRepository(Cow::class)->findQuantidadeTotalRacao();
        $relatorioJovens = $entityManager->getRepository(Cow::class)->findJovensConsumindoMaisRacao();

        $totalLeite = floatval($relatorioLeite);
        $totalRacao = floatval($relatorioRacao);

        return $this->render('dashboard/index.html.twig', [
            'relatorioLeite' => ['totalLeite' => $totalLeite],
            'relatorioRacao' => ['totalRacao' => $totalRacao],
            'relatorioJovens' => $relatorioJovens,
            'pagina' => 'Dashboard'
        ]);
        
    }


}
