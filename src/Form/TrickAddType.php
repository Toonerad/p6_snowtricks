<?php

namespace App\Form;

use App\Entity\Trick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description', TextareaType::class, array('attr' => array('class' => 'ckeditor')))
            ->add('category')
            ->add('images', CollectionType::class,
                [
                    'entry_type'    => ImageType::class,
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'required'      => false,
                    'by_reference'  => false
                ])
            ->add('videos', CollectionType::class,
                [
                    'entry_type'    => VideoType::class,
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'required'      => false,
                    'by_reference'  => false
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
