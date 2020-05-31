<?php

namespace App\Form;

use App\Entity\TempTracker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TempTrackerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('temperature', TextType::class, [
                'required' => true,
                'help' => 'Only decimal numbers allowed.',
                'attr' => ['class' => 'form-control', 'placeholder' => '0.00'],
                'invalid_message' => 'Temperature is invalid.'
            ])
            ->add('createdAt', HiddenType::class, [
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TempTracker::class
        ]);
    }
}
