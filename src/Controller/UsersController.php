<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class UsersController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * UsersController constructor.
     * @param UserRepository $userRepository
     * @param Environment $twig
     */
    public function __construct(UserRepository $userRepository, Environment $twig)
    {
        $this->userRepository = $userRepository;
        $this->twig = $twig;
    }


    /**
     * @Route("/users/{username}", name="users")
     *
     * @param Request $request
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index(Request $request)
    {
        $userRoute = $this->userRepository->findOneBy(['username' => $request->attributes->get('username')]);

        return new Response($this->twig->render('users/index.html.twig', [
            'user' => $userRoute,
        ]));

    }
}
