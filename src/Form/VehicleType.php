<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Coverage;
use App\Entity\Vehicle;
use App\Service\Coverage\CoverageManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehicleType extends AbstractType
{
    /**
     * @var CoverageManager
     */
    private CoverageManager $coverageManager;

    /**
     * Constructor
     *
     * @param CoverageManager $coverageManager
     */
    public function __construct(CoverageManager $coverageManager)
    {
        $this->coverageManager = $coverageManager;
    }

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
            ->add('year', NumberType::class, [
                'label' => 'Year',
            ])
            ->add('make', TextType::class, [
                'label' => 'Make'
            ])
            ->add('model', TextType::class, [
                'label' => 'Model'
            ])
            ->add('vin', NumberType::class, [
                'label' => 'VIN'
            ])
            ->add('vehicleUsage', TextType::class, [
                'label' => 'Usage'
            ])
            ->add('primaryUse', TextType::class, [
                'label' => 'Primary use'
            ])
            ->add('annualMilleage', NumberType::class, [
                'label' => 'Annual milleage'
            ])
            ->add('ownership', TextType::class, [
                'label' => 'Ownership'
            ])
            ->add('coverages', EntityType::class, [
                'class' => Coverage::class,
                'choice_label' => 'label',
                'multiple' => true,
                'choices' => $this->coverageManager->getCoverages(),
            ])
            ->add('garagingAddress', AddressType::class, [
                'label' => 'Garaging address',
            ])
            ->add('register', SubmitType::class, [
                'label' => 'Save',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ])
        ;
    }

    /**
     * Configuration
     *
     * @param OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
