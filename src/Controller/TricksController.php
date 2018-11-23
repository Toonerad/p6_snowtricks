<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class TricksController
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * TricksController constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }


    /**
     * @Route("/tricks", name="tricks")
     *
     * @param TrickRepository $repo
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index(TrickRepository $repo)
    {

        $tricks = $repo->findBy(array(), array('id' => 'DESC'));

        return new Response($this->twig->render('tricks/index.html.twig', [
            'tricks' => $tricks,
        ]));
    }
}
