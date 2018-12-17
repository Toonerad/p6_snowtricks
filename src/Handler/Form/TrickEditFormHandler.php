<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 23/11/2018
 * Time: 19:14
 */

namespace App\Handler\Form;

use App\Repository\TrickRepository;
use App\Service\Slugify;
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
            $trick = $form->getData();
            $trick->setSlug(Slugify::slugify($trick->getName()));
            $trick->setCreatedAt(new \DateTime());
            $this->trickRepository->save($trick);

            return true;
        }
        return false;
    }
}
