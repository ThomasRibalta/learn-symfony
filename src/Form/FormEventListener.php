<?php

namespace App\Form;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\String\Slugger\AsciiSlugger;

class FormEventListener
{
    public function generateSlug(String $field): callable
    {
        return function (PreSubmitEvent $event) use ($field){
          $data = $event->getData();
          if (empty($data['slug'])) {
              $slugger = new AsciiSlugger();
              $data['slug'] = strtolower($slugger->slug($data[$field]));
              $event->setData($data);
          }
        };
    }

    public function setTime(): callable
    {
        return function (FormEvent $event) {
            $recipe = $event->getData();
            $recipe->setUpdatedAt(new \DateTimeImmutable());
            if ($recipe->getId() === null)
                $recipe->setCreatedAt(new \DateTimeImmutable());
        };
    }
}