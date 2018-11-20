<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TricksController extends AbstractController
{
    /**
     * @Route("/tricks", name="tricks")
     *
     * @param TrickRepository $repo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(TrickRepository $repo)
    {

        $tricks = $repo->findAll();

        return $this->render('tricks/index.html.twig', [
            'tricks' => $tricks
        ]);
    }
}
