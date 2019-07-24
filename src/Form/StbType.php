<?php

namespace App\Form;

use App\Entity\Stb;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Player;

class StbType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('players', EntityType::class,[
                'class' => Player::class,
                'choice_label' => 'name',
                'attr' => ['class' => 'choicejs'],
                'multiple' => true
            ])
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stb::class,
        ]);
    }
}
