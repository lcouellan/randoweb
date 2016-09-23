<?php
/**
 * Created by PhpStorm.
 * User: Lenaic
 * Date: 09/05/2016
 * Time: 13:57
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class RandonneeFilterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,array('required' => false,'label'=>'Nom'))
            ->add('distanceMin',IntegerType::class,array('required' => false,'label'=>'Distance minimum'))
            ->add('distanceMax',IntegerType::class,array('required' => false,'label'=>'Distance maximum'))
            ->add('timeMin',IntegerType::class,array('required' => false,'label'=>'Temps minimum'))
            ->add('timeMax',IntegerType::class,array('required' => false,'label'=>'Temps maximum'))
            ->add('difficulty', ChoiceType::class,array(
                'choices' =>array(
                    'Toutes'=> 'toutes',
                    'Facile' => 'facile',
                    'Moyen' => 'moyen',
                    'Difficile' => 'difficile'
                ),'label'=>'Difficulté'
            ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\RandonneeFilter'
        ));
    }

    public function getName()
    {
        return 'app_bundle_randonnee_form';
    }

}