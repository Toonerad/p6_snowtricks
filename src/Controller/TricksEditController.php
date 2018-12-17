<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 23/11/2018
 * Time: 19:02
 */

namespace App\Controller;


use App\Form\TrickEditType;
use App\Handler\Form\TrickEditFormHandler;
use App\Repository\TrickRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class TricksEditController
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
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * TricksEditController constructor.
     * @param TrickRepository $trickRepository
     * @param FormFactoryInterface $formFactory
     * @param UrlGeneratorInterface $urlGenerator
     * @param Environment $twig
     */
    public function __construct(TrickRepository $trickRepository, FormFactoryInterface $formFactory, UrlGeneratorInterface $urlGenerator, Environment $twig)
    {
        $this->trickRepository = $trickRepository;
        $this->formFactory = $formFactory;
        $this->urlGenerator = $urlGenerator;
        $this->twig = $twig;
    }


    /**
     * @Route(path="/tricks/{slug}/edit", name="tricks_edit")
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     * @param TrickEditFormHandler $formHandler
     * @return Response|RedirectResponse
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function edit(Request $request, TrickEditFormHandler $formHandler )
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $request->attributes->get('slug') ]);

        $form = $this->formFactory->create(TrickEditType::class, $trick)->handleRequest($request);

        if($formHandler->handle($form)) {
            $request->getSession()->getFlashBag()->add('success', 'La figure à été correctement modifié');
            return new RedirectResponse($this->urlGenerator->generate('tricks_show', ['slug' => $trick->getSlug()]));
        }

        return new Response($this->twig->render('tricks/tricks_edit.html.twig', [
            'formTricksEdit' => $form->createView()
        ]));
    }

}