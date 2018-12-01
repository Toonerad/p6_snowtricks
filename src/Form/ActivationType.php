<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ActivationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', TextType::class, array(
                    'constraints' => array(
                        new NotBlank(['message' => "Merci de soumettre le code envoyé par email"]),
                        new Length(['max' => 6,
                            'maxMessage' => "Le code doit faire minimum 6 caractères",
                            ]),
                        new EqualTo([
                            "value" => $options['csrf_field_name'],
                            "message" => "Le code n'est pas valide"
                            ]),
                    ),
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

        ]);
    }
}
