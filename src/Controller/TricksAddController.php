<?php

namespace App\Controller;

use App\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class TricksAddController extends AbstractController
{
    /**
     * @Route("/tricks/add", name="tricks_add")
     * @IsGranted("ROLE_USER")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create()
    {
        $trick = new Trick();

        $form = $this->createFormBuilder($trick)
                    ->add('name')
                    ->add('description')
                    ->add('category')
                    ->getForm();

        return $this->render('tricks/tricks_add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
