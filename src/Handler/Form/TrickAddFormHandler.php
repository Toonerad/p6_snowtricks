<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 22/11/2018
 * Time: 22:00
 */

namespace App\Handler\Form;


use App\Repository\TrickRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormInterface;

class TrickAddFormHandler
{

    /**
     * @var TrickRepository
     */
    private $trickRepository;

    /**
     * TrickAddFormHandler constructor.
     * @param TrickRepository $trickRepository
     */
    public function __construct(TrickRepository $trickRepository)
    {
        $this->trickRepository = $trickRepository;
    }


    public function handle(FormInterface $form)
    {
        if($form->isSubmitted() && $form->isValid())
        {
            $trick = $form->getData();
            $this->trickRepository->save($trick);

            return true;
        }
        return false;
    }

}