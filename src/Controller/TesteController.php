<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class TesteController extends AbstractController
{
    /**
     * @@Route("/",name="teste")
     */
    public function index(): Response
    {
       return $this-> render('teste/teste.html.twig');
    }
}