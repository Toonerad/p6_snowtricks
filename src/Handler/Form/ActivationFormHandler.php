<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 01/12/2018
 * Time: 16:31
 */

namespace App\Handler\Form;


use Symfony\Component\Form\FormInterface;

class ActivationFormHandler
{
    public function handle(FormInterface $form)
    {
        if($form->isSubmitted() && $form->isValid())
        {
            $formData = $form->getData();
            $code = $formData['code'];
            $codeUser = $formData['codeUser'];

            if(!($code == $codeUser)){
                return false;
            }

            return true;
        }

    }


}