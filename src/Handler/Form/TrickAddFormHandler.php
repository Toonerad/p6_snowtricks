<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 22/11/2018
 * Time: 22:00
 */

namespace App\Handler\Form;


use App\Repository\TrickRepository;
use App\Service\FileUploader;
use Symfony\Component\Form\FormInterface;

class TrickAddFormHandler
{

    /**
     * @var TrickRepository
     */
    private $trickRepository;

    /**
     * @var FileUploader
     */
    private $fileUploader;

    /**
     * TrickAddFormHandler constructor.
     * @param TrickRepository $trickRepository
     * @param FileUploader $fileUploader
     */
    public function __construct(TrickRepository $trickRepository, FileUploader $fileUploader)
    {
        $this->trickRepository = $trickRepository;
        $this->fileUploader = $fileUploader;
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