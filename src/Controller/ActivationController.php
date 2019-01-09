<?php

namespace App\Controller;

use App\Form\ActivationType;
use App\Handler\Form\ActivationFormHandler;
use App\Mailer\SendMailer;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class ActivationController
{
    /**
     * @var UserRepository;
     */
    private $userRepo;

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
     * @var SendMailer
     */
    private $sendMailer;

    /**
     * ActivationController constructor.
     * @param UserRepository $userRepo
     * @param FormFactoryInterface $formFactory
     * @param UrlGeneratorInterface $urlGenerator
     * @param Environment $twig
     * @param SendMailer $sendMailer
     */
    public function __construct(UserRepository $userRepo, FormFactoryInterface $formFactory, UrlGeneratorInterface $urlGenerator, Environment $twig, SendMailer $sendMailer)
    {
        $this->userRepo = $userRepo;
        $this->formFactory = $formFactory;
        $this->urlGenerator = $urlGenerator;
        $this->twig = $twig;
        $this->sendMailer = $sendMailer;
    }


    /**
     * @Route("/activation/{token}", name="activation")
     *
     * @param Request $request
     * @param ActivationFormHandler $formHandler
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function activation(Request $request, ActivationFormHandler $formHandler)
    {
        $token = $request->attributes->get('token');
        $user = $this->userRepo->findOneBy(['token' => $token]);
        if(!$user){
            return new RedirectResponse($this->urlGenerator->generate('homepage'));
        }elseif ($user->getIsActivated() != 0){
            return new RedirectResponse($this->urlGenerator->generate('homepage'));
        }
        $codeUser = $user->getCode();

        $form = $this->formFactory->create(ActivationType::class, ['codeUser' => $codeUser], ['csrf_field_name' => $codeUser])->handleRequest($request);


        if($formHandler->handle($form)) {
            $user->setIsActivated(1);
            $this->userRepo->flush();
            $this->sendMailer->send("Vérification de votre compte", ["no-reply@lucasbassand.com" => "SnowTricks"], $user->getEmail(), "emails/success.html.twig", ['user' => $user ]);

            return new RedirectResponse($this->urlGenerator->generate('success', ['token' => $token]));
        }


        return new Response($this->twig->render('activation/index.html.twig', [
            'formActivation' => $form->createView(),
        ]));
    }
}
