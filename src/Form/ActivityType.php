<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\Domain;
use App\Entity\Skill;
use App\Entity\Style;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('domain', EntityType::class, [

                'label' => 'Domaine',
                'class' => Domain::class,
                'choice_label' => 'name',

            ])

            ->add('skill', EntityType::class, [

                'label' => 'Accessoire',
                'class' => Skill::class,
                'choice_label' => 'name',

            ])

            ->add('style', EntityType::class, [

                'label' => 'Style',
                'class' => Style::class,
                'choice_label' => 'type',

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class', null => Activity::class,
        ]);
    }
}
