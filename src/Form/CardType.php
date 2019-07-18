<?php

namespace App\Form;

use App\Entity\Card;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reset', SubmitType::class, [
                'label' => 'À revoir',
                'attr' => ['class' => 'btn btn-outline-danger']
            ])
            ->add('hard', SubmitType::class, [
                'label' => 'Difficile',
                'attr' => ['class' => 'btn btn-outline-warning']
            ])
            ->add('medium', SubmitType::class, [
                'label' => 'Correct',
                'attr' => ['class' => 'btn btn-outline-info']
            ])
            ->add('easy', SubmitType::class, [
                'label' => 'Facile',
                'attr' => ['class' => 'btn btn-outline-success']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}
