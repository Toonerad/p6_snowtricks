<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TricksShowController extends AbstractController
{

    /**
     * @var TrickRepository
     */
    private $trickRepository;

    /**
     * TricksShowController constructor.
     * @param TrickRepository $trickRepository
     */
    public function __construct(TrickRepository $trickRepository)
    {
        $this->trickRepository = $trickRepository;
    }


    /**
     * @Route("/tricks/{slug}", name="tricks_show")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Request $request)
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $request->attributes->get('slug') ]);

        //A changer
        return $this->render('tricks/tricks_show.html.twig', [
            'trick' => $trick
        ]);
    }
}
