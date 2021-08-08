<?php

namespace App\Form;

use DateTime;
use App\Entity\Order;
use App\Entity\Member;
use App\Entity\Vehicle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class OrderAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('memberId', EntityType::class, [
                'class' => Member::class,
                'choice_label' => 'login',
                'label' => 'Client',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Login du client'
                ],
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'label_attr'=> [
                    'class' => 'form-label'
                ]
            ])
            ->add('vehicleId', EntityType::class, [
                'class' => Vehicle::class,
                'choice_label' => 'title',
                'label' => 'Véhicule',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom complet du véhicule'
                ],
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'label_attr'=> [
                    'class' => 'form-label'
                ]
            ])
            ->add('datetimeFrom', DateTimeType::class, [
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
            ->add('datetimeTo', DateTimeType::class, [
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
            ->add('totalPrice', NumberType::class, [
                'label' => 'Prix de la location',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Prix de la location'
                ],
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'label_attr'=> [
                    'class' => 'form-label mt-4'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
