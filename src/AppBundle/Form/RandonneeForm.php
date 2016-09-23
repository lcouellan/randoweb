<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RandonneeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name',TextType::class,array('label'=>'Nom'))
                ->add('distance',NumberType::class)
                ->add('time',IntegerType::class,array('label'=>'Temps'))
                ->add('difficulty', ChoiceType::class,array(
                    'choices' =>array(
                        'Facile' => 'facile',
                        'Moyen' => 'moyen',
                        'Difficile' => 'difficile'
                    ),'label'=>'Difficulté'
                ))
                ->add('image', FileType::class, array('label' => 'Image'))
                ->add('trace', FileType::class, array('label' => 'Tracé du parcours (format GPX)'))
                ->add('description',TextareaType::class,array(
                    'attr' => array('class' => 'tinymce')
                ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Randonnee'
        ));
    }

    public function getName()
    {
        return 'app_bundle_randonnee_form';
    }
}
