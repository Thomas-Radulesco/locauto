<?php

namespace App\Form;

use DateTime;
use App\Entity\Order;
use App\Entity\Member;
use App\Entity\Vehicle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('confirm', CheckboxType::class, [
                'row_attr' => [
                    'class' => 'form-group mb-4',
                ],
                'label_attr'=> [
                    'class' => 'form-label'
                ],
                'label' => 'Je confirme la réservation',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Pour aller plus loin, merci de confirmer la réservation.',
                    ]),
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
