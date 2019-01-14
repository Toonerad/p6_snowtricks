<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\AddCommentType;
use App\Form\CommentAddType;
use App\Handler\Form\AddCommentFormHandler;
use App\Handler\Form\CommentAddFormHandler;
use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class TricksShowController extends AbstractController
{

    /**
     * @var TrickRepository
     */
    private $trickRepository;

    /**
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * TricksShowController constructor.
     * @param TrickRepository $trickRepository
     * @param CommentRepository $commentRepository
     * @param FormFactoryInterface $formFactory
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(TrickRepository $trickRepository, CommentRepository $commentRepository, FormFactoryInterface $formFactory, UrlGeneratorInterface $urlGenerator)
    {
        $this->trickRepository = $trickRepository;
        $this->commentRepository = $commentRepository;
        $this->formFactory = $formFactory;
        $this->urlGenerator = $urlGenerator;
    }


    /**
     * @Route("/tricks/{slug}", name="tricks_show")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Request $request, CommentAddFormHandler $formHandler)
    {
        $slug = $request->attributes->get('slug');
        $trick = $this->trickRepository->findOneBy(['slug' => $slug ]);
        $trick_id = $trick->getId();
        $comments = $this->commentRepository->findBy(['trick_id' => $trick_id]);

        $comment = new Comment();
        $user = $this->getUser();


        if($user){
            $username = $user->getUsername();
            $form = $this->formFactory->create(CommentAddType::class, $comment, array('username' => $username, 'trick_id' => $trick_id))->handleRequest($request);

            if($formHandler->handle($form)) {
                return new RedirectResponse($this->urlGenerator->generate('tricks_show', ['slug' => $slug]));
            }

            return $this->render('tricks/tricks_show.html.twig', [
                'trick' => $trick,
                'formCommentAdd' => $form->createView(),
                'comments' => $comments,
            ]);
        }

        return $this->render('tricks/tricks_show.html.twig', [
            'trick' => $trick,
            'comments' => $comments,
        ]);




    }
}
