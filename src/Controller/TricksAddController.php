<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TricksAddController extends AbstractController
{
    /**
     * @Route("/tricks/add", name="tricks_add")
     */
    public function create()
    {
        return $this->render('tricks/tricks_add.html.twig');
    }
}
