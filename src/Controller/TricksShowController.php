<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\AddCommentType;
use App\Form\CommentAddType;
use App\Handler\Form\AddCommentFormHandler;
use App\Handler\Form\CommentAddFormHandler;
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
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * TricksShowController constructor.
     * @param TrickRepository $trickRepository
     * @param FormFactoryInterface $formFactory
     * @param UserInterface $user
     */
    public function __construct(TrickRepository $trickRepository, FormFactoryInterface $formFactory)
    {
        $this->trickRepository = $trickRepository;
        $this->formFactory = $formFactory;
    }


    /**
     * @Route("/tricks/{slug}", name="tricks_show")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Request $request, CommentAddFormHandler $formHandler)
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $request->attributes->get('slug') ]);

        $comment = new Comment();

        $username = $this->getUser()->getUsername();
        $trick_id = $trick->getId();


        $form = $this->formFactory->create(CommentAddType::class, $comment, array('username' => $username, 'trick_id' => $trick_id))->handleRequest($request);

        if($formHandler->handle($form)) {

        }

        return $this->render('tricks/tricks_show.html.twig', [
            'trick' => $trick,
            'formCommentAdd' => $form->createView(),
        ]);
    }
}
