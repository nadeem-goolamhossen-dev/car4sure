<?php

namespace App\Form;

use App\Entity\License;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LicenseType extends AbstractType
{
    /**
     * Build form
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number', NumberType::class, [
                'label' => 'Number',
            ])
            ->add('state', TextType::class, [
                'label' => 'License state',
            ])
            ->add('effectiveDate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('expirationDate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('class', TextType::class, [
                'label' => 'License class',
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Status',
                'choices' => [
                    'Choose' => null,
                    'Valid' => 1,
                    'Invalid' => 0,
                ],
            ])
        ;
    }

    /**
     * Configurations
     *
     * @param OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => License::class,
        ]);
    }
}
