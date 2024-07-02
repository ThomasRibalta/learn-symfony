<?php

namespace App\Form;

use App\DTO\ContactDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Choice;

class ContactType extends AbstractType
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
            ->add('message', TextType::class, 
            [
                'empty_data' => ''
            ])
            ->add('service', ChoiceType::class,
            [
                'choices' => [
                    'Compta' => 'compta@demo.fr',
                    'Helper' => 'helper@demo.fr',
                    'Marketing' => 'marketing@demo.fr',
                ],
                'empty_data' => ''
            ])
            ->add('save', SubmitType::class, 
            [
                'label' => 'Submit',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactDTO::class,
        ]);
    }
}
