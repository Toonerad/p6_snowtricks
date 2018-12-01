<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @var AuthenticationUtils
     */
    private $authenError;

    /**
     * SecurityController constructor.
     * @param AuthenticationUtils $authenError
     */
    public function __construct(AuthenticationUtils $authenError)
    {
        $this->authenError = $authenError;
    }


    /**
     * @Route(path="/register", name="security_registration")
     *
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setIsActivated(false);
            $token = bin2hex(random_bytes(78));
            $code = strtoupper(bin2hex(random_bytes(3))) ;
            $user->setToken($token);
            $user->setCode($code);
            $manager->persist($user);
            $manager->flush();


            return $this->redirectToRoute("security_login");
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route(path="/login", name="security_login")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login()
    {
        $error = $this->authenError->getLastAuthenticationError();

        return $this->render('security/login.html.twig', [
            'error' => $error,
        ]);
    }


    /**
     * @Route(path="/logout", name="security_logout")
     */
    public function logout() {}

}
