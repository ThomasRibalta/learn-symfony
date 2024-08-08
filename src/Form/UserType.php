<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, 
            [
                'empty_data' => ''
            ])
            ->add('email', TextType::class, 
            [
                'empty_data' => ''
            ])
            ->add('roles', ChoiceType::class,
            [
                'choices' => [
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                'expanded' => true,
                'empty_data' => ''
            ])
            ->add('save', SubmitType::class, 
            [
                'label' => 'Submit',
            ])
        ;
    }
}