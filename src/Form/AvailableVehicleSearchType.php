<?php

namespace App\Form;

use App\Entity\AvailableVehicleSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class AvailableVehicleSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fromDate', DateTimeType::class, [
                'label' => 'Début de location',
                'required' => true,
                'widget' => 'single_text',
                'model_timezone' => 'Europe/Paris',
                'view_timezone' => 'Europe/Paris',
                'attr' => [
                    'class' => 'form-control',
                    'min' => "2021-01-01",
                ],
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'label_attr'=> [
                    'class' => 'form-label'
                ]
            ])
            ->add('toDate', DateTimeType::class, [
                'label' => 'Fin de location',
                'required' => true,
                'widget' => 'single_text',
                'model_timezone' => 'Europe/Paris',
                'view_timezone' => 'Europe/Paris',
                'attr' => [
                    'class' => 'form-control',
                    'min' => "2021-01-01",
                ],
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'label_attr'=> [
                    'class' => 'form-label'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AvailableVehicleSearch::class,
            'method' => 'get',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
