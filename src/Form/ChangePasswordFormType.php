<?php

namespace App\Form;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'mapped' => false,
                'label' => 'Votre mot de passe actuel',
                'attr' => [
                    'placeholder'=>'votre mot de passe actuel',
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'label_attr'=> [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new UserPassword([
                        'message' => 'Votre mot de passe actuel ne correspond pas'
                    ])
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'class' => 'password-field',
                    'autocomplete' => 'new-password',
                ],
                'first_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci d\'entrer un mot de passe',
                        ]),
                        new Length([
                            'min' => 8,
                            'minMessage' => 'Le mot de passe doit avoir au moins {{ limit }} caract??res',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                    'label' => 'Nouveau mot de passe',
                    'attr' => [
                        'placeholder'=>'votre nouveau mot de passe',
                        'class' => 'form-control',
                    ],
                    'row_attr' => [
                        'class' => 'form-group',
                    ],
                    'label_attr'=> [
                        'class' => 'form-label mt-4'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmez le mot de passe',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder'=>'confirmez votre mot de passe',
                        'autocomplete' => 'new-password',
                    ],
                    'row_attr' => [
                        'class' => 'form-group',
                    ],
                    'label_attr'=> [
                        'class' => 'form-label mt-4'
                    ]
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
