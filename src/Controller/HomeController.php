<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(TrickRepository $repo)
    {

        $tricks = $repo->findBy(array(), array('id' => 'DESC'),4);

        return $this->render('home/index.html.twig', [
            'tricks' => $tricks
        ]);
    }
}
