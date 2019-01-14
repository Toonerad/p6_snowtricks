<?php

namespace App\Controller;

use App\Repository\CommentRepository;
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
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * UsersController constructor.
     * @param UserRepository $userRepository
     * @param CommentRepository $commentRepository
     * @param Environment $twig
     */
    public function __construct(UserRepository $userRepository, CommentRepository $commentRepository, Environment $twig)
    {
        $this->userRepository = $userRepository;
        $this->commentRepository = $commentRepository;
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
        $username = $request->attributes->get('username');
        $userRoute = $this->userRepository->findOneBy(['username' => $username]);

        $lastComment = $this->commentRepository->findOneBy(['author' => $username], ['id' => 'DESC']);

        return new Response($this->twig->render('users/index.html.twig', [
            'user' => $userRoute,
            'lastComment' => $lastComment,
        ]));

    }
}
