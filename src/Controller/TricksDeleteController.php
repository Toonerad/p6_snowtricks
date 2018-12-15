<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 04/12/2018
 * Time: 23:51
 */

namespace App\Controller;


use App\Repository\TrickRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class TricksDeleteController
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
     * @var Environment
     */
    private $twig;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * TricksDeleteController constructor.
     * @param TrickRepository $trickRepository
     * @param FormFactoryInterface $formFactory
     * @param Environment $twig
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(TrickRepository $trickRepository, FormFactoryInterface $formFactory, Environment $twig, UrlGeneratorInterface $urlGenerator)
    {
        $this->trickRepository = $trickRepository;
        $this->formFactory = $formFactory;
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
    }


    /**
     * @Route(path="/tricks/delete/{id}", name="delete_tricks")
     *
     *
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @return RedirectResponse
     */
    public function deleteTrick(Request $request)
    {
        $trick = $this->trickRepository->find($request->attributes->get('id'));

        $form = $this->formFactory->create();

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $this->trickRepository->delete($trick);
            $request->getSession()->getFlashBag()->add('success', 'La figure a été supprimé');
            return new RedirectResponse($this->urlGenerator->generate('homepage'));
        }


        return new Response($this->twig->render('tricks/tricks_delete.html.twig', [
            'form' => $form->createView(),
            'trick' => $trick
        ]));

    }
}
