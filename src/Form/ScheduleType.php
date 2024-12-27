<?php

namespace App\Form;

use App\Entity\Schedule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lesson', TextType::class, [
                'label' => 'Lesson Name',
                'required' => true,
            ])
            ->add('start_time', DateTimeType::class, [
                'label' => 'Start Time',
                'required' => true,
                'widget' => 'single_text',
            ])
            ->add('end_time', DateTimeType::class, [
                'label' => 'End Time',
                'required' => true,
                'widget' => 'single_text',
            ])
            ->add('teacher', TextType::class, [
                'label' => 'Teacher Name',
                'required' => true,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save Schedule'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Schedule::class,
        ]);
    }
}
