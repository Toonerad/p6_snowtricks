<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentAddType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $username = $options['username'];
        $trick_id = $options['trick_id'];

        $builder
            ->add('author', TextType::class, array('label' => false, 'attr' => ['value' => $username, 'hidden' => true]))
            ->add('content')
            ->add('trick_id', TextType::class, array('label' => false, 'attr' => ['value' => $trick_id, 'hidden' => true]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
        $resolver->setRequired('username');
        $resolver->setRequired('trick_id');
    }
}
