<?php

namespace App\Form;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', TextType::class, [
                'label' => 'Login',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'TheJohnDoe'
                ],
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'label_attr'=> [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'John'
                ],
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'label_attr'=> [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Doe'
                ],
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'label_attr'=> [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('emailAddress', EmailType::class, [
                'constraints' => [
                    new Email,
                    new NotBlank,
                ],
                'label' => 'Adresse mail',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'john@doe.com'
                ],
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'label_attr'=> [
                    'class' => 'form-label mt-4'
                ],
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Non spécifié' => 'Non spécifié',
                    'Femme' => 'Femme',
                    'Homme' => 'Homme'
                ],
                'label' => 'Femme / Homme',
                'attr' => [
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'label_attr'=> [
                    'class' => 'form-label mt-4'
                ]
            ])
            // ->add('plainPassword', RepeatedType::class, [
            //     // instead of being set onto the object directly,
            //     // this is read and encoded in the controller
            //     'mapped' => false,
            //     'label' => 'Mot de passe',
            //     'required' => false,
            //     'type' => PasswordType::class,
            //     'invalid_message' => 'Les mots de passe doivent correspondre',
            //     'first_name' => 'password',
            //     'second_name' => 'confirm_password',
            //     'attr' => [
            //         'class' => 'password-field',
            //         'autocomplete' => 'new-password'
            //     ],
            //     'first_options'  => [
            //         'label' => 'Mot de passe',
            //         'attr' => [
            //             'placeholder'=>'votre mot de passe',
            //             'class' => 'form-control',
            //         ],
            //         'row_attr' => [
            //             'class' => 'form-group',
            //         ],
            //         'label_attr'=> [
            //             'class' => 'form-label mt-4'
            //         ]
            //     ],
            //     'second_options' => [
            //         'label' => 'Confirmez votre mot de passe',
            //         'attr' => [
            //             'class' => 'form-control',
            //             'placeholder'=>'confirmez votre mot de passe',
            //         ],
            //         'row_attr' => [
            //             'class' => 'form-group',
            //         ],
            //         'label_attr'=> [
            //             'class' => 'form-label mt-4'
            //         ]
            //     ],
            //     'constraints' => [
            //         new Length([
            //             'min' => 6,
            //             'minMessage' => 'Your password should be at least {{ limit }} characters',
            //             // max length allowed by Symfony for security reasons
            //             'max' => 4096,
            //         ]),
            //     ],
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
