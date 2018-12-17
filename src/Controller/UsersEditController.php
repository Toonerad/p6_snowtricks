<?php

namespace App\Controller;

use App\Form\UserEditType;
use App\Handler\Form\UserEditFormHandler;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UsersEditController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;


    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * UsersEditController constructor.
     * @param UserRepository $userRepository
     * @param FormFactoryInterface $formFactory
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(UserRepository $userRepository, FormFactoryInterface $formFactory, UrlGeneratorInterface $urlGenerator)
    {
        $this->userRepository = $userRepository;
        $this->formFactory = $formFactory;
        $this->urlGenerator = $urlGenerator;
    }


    /**
     *  @Route("/users/{user}/edit", name="users_edit")
     *  @IsGranted("ROLE_USER")
     *
     * @param Request $request
     * @param UserEditFormHandler $formHandler
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, UserEditFormHandler $formHandler)
    {
        $userRoute = $this->userRepository->findOneBy(['username' => $request->attributes->get('user')]);
        $userLogged = $this->getUser();

        if($userRoute != $userLogged){
            //Redirigez vers une page 404
            return new RedirectResponse($this->urlGenerator->generate('homepage'));
        }

        $form = $this->formFactory->create(UserEditType::class, $userLogged)->handleRequest($request);

        if($formHandler->handle($form)) {
            $request->getSession()->getFlashBag()->add('success', 'Profil modifié');
            return new RedirectResponse($this->urlGenerator->generate('users', ['username' => $userLogged->getUsername() ]));
        }



        return $this->render('users/users_edit.html.twig', [
            'formUserEdit' => $form->createView(),
        ]);
    }
}
