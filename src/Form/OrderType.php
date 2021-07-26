<?php

namespace App\Form;

use DateTime;
use App\Entity\Order;
use App\Entity\Member;
use App\Entity\Vehicle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datetimeFrom', DateType::class, [
                'label' => 'From',
                'required' => true,
                'widget' => 'single_text',
                'model_timezone' => 'Europe/Paris',
                'view_timezone' => 'Europe/Paris',
                'attr' => [
                    'min' => "2021-01-01",
                ],
            ])
            ->add('datetimeTo', DateType::class, [
                'label' => 'To',
                'required' => true,
                'widget' => 'single_text',
                'model_timezone' => 'Europe/Paris',
                'view_timezone' => 'Europe/Paris',
                'attr' => [
                    'min' => "2021-01-01",
                ],
            ])
            ->add('totalPrice')
            ->add('memberId', EntityType::class, [
                'class' => Member::class,
                'choice_label' => 'login',
            ])
            ->add('vehicleId', EntityType::class, [
                'class' => Vehicle::class,
                'choice_label' => 'title',
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
