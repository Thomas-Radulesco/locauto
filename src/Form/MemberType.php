<?php

namespace App\Form;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roles', ChoiceType::class, [
                'attr' => ['class' => 'align-items-center'],
                'label_attr' => [
                    'class' => 'd-none',
                ],
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                'expanded' => true,
                'choice_attr' => [
                    'Administrateur' => [
                        'class' => 'me-2'
                    ],
                    'class' => 'me-2',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
