<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\IsTrue;

class RegistrationFormCustomer extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => 'nom',
            ])
            ->add('firstname', TextType::class, [
                'label' => 'prenom',
            ])
            ->add('email', EmailType::class, [
                'label' => 'email',
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'registration.message.repeated_password_invalid',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'mot de passe'],
                'second_options' => ['label' => 'confirmez votre mot de passe'],
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'registration.message.password_not_blank',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins 6 caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('phone', IntegerType::class, [
                'label' => 'téléphone',
                'constraints' =>[
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Votre numero de téléphone doit contenir 10 chiffres',
                        'max' => 10,
                    ])
                ]
            ])
            ->add('adress', TextType::class, [
                'label' => 'adresse',
            ])
            ->add('zip_code', IntegerType::class, [
                'label' => 'code postal',
                'constraints' =>[
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Votre code postal doit contenir 5 chiffres',
                        'max' => 5,
                    ])
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'ville',
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'J\'accepte les termes du contrat',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'registration.message.agree_terms_is_true',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
            'translation_domain' => 'security',
        ]);
    }
}
