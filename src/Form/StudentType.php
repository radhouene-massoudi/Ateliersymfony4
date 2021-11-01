<?php

namespace App\Form;

use App\Entity\Classroom;
use App\Entity\Club;
use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nsc')
            ->add('email')
            ->add('creationDate')
            ->add('DateOfBirth')
            ->add('enabled')
            ->add('moyenne')
            ->add('clubs',EntityType::class,[
                'class' => Club::class,
                'choice_label' => 'ref',
                'expanded' => true,
                'multiple' => true
            ])
            ->add('classroom',EntityType::class,[
                'class'=>Classroom::class,
                'choice_label'=>'name',
                'expanded'=>true,
                'multiple'=>false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
