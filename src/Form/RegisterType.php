<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'required'      => true,
                'constraints' => new Length(['min' => 3]),
                'attr'  => [
                    'placeholder' => 'Merci de saisir votre prénom']
            ])

            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'required'      => true,
                'constraints' => new Length(['min' => 3]),
                'attr'  => [
                    'placeholder' => 'Merci de saisir votre nom']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'required'      => true,
                'constraints' => new Length(['min' => 3]),
                'attr'  => [
                    'placeholder' => 'Merci de saisir votre adresse email']
            ])

            ->add('Password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'le mot de passe et la confirmation doivent étre identique',
                'label' => 'Votre mot de passe',
                'required' => true,
                'first_options' => ['label' =>'Mot de passe',
                                    'attr' => ['placeholder' => 'Merci de saisir votre mot de passe']],
                'second_options'=> ['label' =>'Confirmer votre mot de passe',
                                    'attr' => ['placeholder' => 'Merci de confirmer votre mot de passe']],

                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit être au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])


            ->add('submit', SubmitType::class, [
                'label' =>"S'inscrire"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
