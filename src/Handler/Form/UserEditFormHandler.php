<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 15/12/2018
 * Time: 14:56
 */

namespace App\Handler\Form;


use App\Repository\UserRepository;

class UserEditFormHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserEditFormHandler constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function handle($form)
    {
        if($form->isSubmitted() && $form->isValid())
        {
            $this->userRepository->flush();
            return true;
        }
        return false;
    }
}