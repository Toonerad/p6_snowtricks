<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController
{

    /**
     * @var Environment
     */
    private $twig;

    /**
     * HomeController constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }


    /**
     * @Route("/", name="homepage")
     *
     * @param TrickRepository $repo
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index(TrickRepository $repo)
    {
        //Wait before find system pagination
        $tricks = $repo->findBy(array(), array('id' => 'DESC'));

        return new Response($this->twig->render('home/index.html.twig', [
            'tricks' => $tricks,
        ]));

    }
}
