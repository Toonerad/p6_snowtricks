<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 22/11/2018
 * Time: 22:00
 */

namespace App\Handler\Form;


use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use App\Service\FileUploader;
use App\Service\Slugify;
use Symfony\Component\Form\FormInterface;

class CommentAddFormHandler
{

    /**
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * CommentAddFormHandler constructor.
     * @param CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }


    public function handle(FormInterface $form)
    {
        if($form->isSubmitted() && $form->isValid())
        {
            $comment = $form->getData();
            $this->commentRepository->save($comment);
            return true;
        }
        return false;
    }


}
