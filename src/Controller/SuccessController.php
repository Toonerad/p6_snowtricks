<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 01/12/2018
 * Time: 18:09
 */

namespace App\Controller;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class SuccessController
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * SuccessController constructor.
     * @param UrlGeneratorInterface $urlGenerator
     * @param Environment $twig
     */
    public function __construct(UrlGeneratorInterface $urlGenerator, Environment $twig)
    {
        $this->urlGenerator = $urlGenerator;
        $this->twig = $twig;
    }


    /**
     * @Route(path="/success/{token}", name="success")
     *
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function success(Request $request)
    {
        $previousUrl = $request->headers->get('referer');
        $token = $request->attributes->get('token');
        

        if (strpos($previousUrl, $token) === false) {
            return new RedirectResponse($this->urlGenerator->generate('homepage'));
        }

        return new Response($this->twig->render('activation/success.html.twig'));


    }


}