<?php

namespace App\Form\Filters;

use App\Entity\Category;
use App\Filters\FilterExpense;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterExpenseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $amountOption = [
            'required' => false,
            'scale' => 2,
            'html5' => true,
            'attr' => [
                'min' => 0,
                'step' => 0.01
            ]
        ];

        $builder
            ->add('start', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('end', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('minAmount', NumberType::class, $amountOption)
            ->add('maxAmount', NumberType::class, $amountOption)
            ->add('category', EntityType::class, [
                'required' => false,
                'class' => Category::class,
                'choice_label' => 'title',
                'multiple' => false,
                'expanded' => false,
                'placeholder' => 'placeholder.filter_expense.category',
            ])
            ->add('isCash', ChoiceType::class, [
                'required' => false,
                'multiple' => false,
                'expanded' => false,
                'choices' => [
                    'filter_choices.is_cash.only_cash' => true,
                    'filter_choices.is_cash.exclude_cash' => false,
                ],
                'placeholder' => 'filter_choices.is_cash.all'
            ])
            ->add('isGain', ChoiceType::class, [
                'required' => false,
                'multiple' => false,
                'expanded' => false,
                'choices' => [
                    'filter_choices.is_gain.only_gain' => true,
                    'filter_choices.is_gain.only_expense' => false,
                ],
                'placeholder' => 'filter_choices.is_gain.all'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FilterExpense::class,
        ]);
    }
}