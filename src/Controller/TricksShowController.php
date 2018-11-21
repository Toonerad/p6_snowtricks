<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TricksShowController extends AbstractController
{
    /**
     * @Route("/tricks/{id}", name="tricks_show")
     *
     * @param Trick $trick
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Trick $trick)
    {
        return $this->render('tricks/tricks_show.html.twig', [
            'controller_name' => 'TricksShowController',
            'trick' => $trick
        ]);
    }
}
