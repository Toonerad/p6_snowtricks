<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 23/11/2018
 * Time: 19:14
 */

namespace App\Handler\Form;

use App\Repository\TrickRepository;
use Symfony\Component\Form\FormInterface;

class TrickEditFormHandler
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
            $this->trickRepository->flush();

            return true;
        }
        return false;
    }
}
