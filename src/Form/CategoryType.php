<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\Category;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategoryType extends AbstractType
{
    public function __construct(private FormEventListener $listener)
    {
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,
                [
                    'empty_data' => '',
                ])
            ->add('slug', TextType::class,
                [
                    'empty_data' => '',
                    'required' => false,
                ])
            ->add('save', SubmitType::class,
                [
                    'label' => 'Submit',
                ])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->listener->generateSlug('title'))
            ->addEventListener(FormEvents::POST_SUBMIT, $this->listener->setTime())
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
