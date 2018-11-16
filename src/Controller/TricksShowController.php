<?php

namespace App\Controller;

use App\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TricksShowController extends AbstractController
{
    /**
     * @Route("/tricks/{id}", name="tricks_show")
     */
    public function show($id)
    {

        $repo = $this->getDoctrine()->getRepository(Trick::class);

        $trick = $repo->find($id);

        return $this->render('tricks/tricks_show.html.twig', [
            'controller_name' => 'TricksShowController',
            'trick' => $trick
        ]);
    }
}
