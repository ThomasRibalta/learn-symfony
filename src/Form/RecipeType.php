<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('slug', TextType::class, [
                'required' => false,
            ])
            ->add('content')
            ->add('duration')
            ->add('save', SubmitType::class, [
                'label' => 'Submit',
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->generateSlug(...))
            ->addEventListener(FormEvents::POST_SUBMIT, $this->setTime(...))
        ;
    }

    public function generateSlug(FormEvent $event): void
    {
        $data = $event->getData();
        if (empty($data['slug'])) {
            $slugger = new AsciiSlugger();
            $data['slug'] = strtolower($slugger->slug($data['title']));
            $event->setData($data);
        }
    }

    public function setTime(FormEvent $event): void
    {
        $recipe = $event->getData();
        if (!$recipe instanceof Recipe) {
            return;
        }
        $recipe->setUpdatedAt(new \DateTimeImmutable());
        if ($recipe->getId() === null)
            $recipe->setCreatedAt(new \DateTimeImmutable());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
