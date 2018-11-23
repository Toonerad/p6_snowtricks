<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickAddType;
use App\Handler\Form\TrickAddFormHandler;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;


class TricksAddController
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * TricksAddController constructor.
     * @param FormFactoryInterface $formFactory
     * @param UrlGeneratorInterface $urlGenerator
     * @param Environment $twig
     */
    public function __construct(FormFactoryInterface $formFactory, UrlGeneratorInterface $urlGenerator, Environment $twig)
    {
        $this->formFactory = $formFactory;
        $this->urlGenerator = $urlGenerator;
        $this->twig = $twig;
    }

    /**
     * @Route("/tricks/add", name="tricks_add")
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     * @param TrickAddFormHandler $formHandler
     * @return RedirectResponse|Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function create(Request $request, TrickAddFormHandler $formHandler)
    {

        $trick = new Trick();

        $form = $this->formFactory->create(TrickAddType::class, $trick)->handleRequest($request);

        if($formHandler->handle($form)) {
            return new RedirectResponse($this->urlGenerator->generate('tricks_show', ['id' => $trick->getId()]));
        }

        return new Response($this->twig->render('tricks/tricks_add.html.twig', [
            'formTricksAdd' => $form->createView()
        ]));

    }
}
