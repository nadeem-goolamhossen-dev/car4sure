<?php

namespace App\Form;

use App\Entity\Coverage;
use App\Entity\Vehicle;
use App\Repository\CoverageRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehicleType extends AbstractType
{
    private CoverageRepository $coverageRepository;

    public function __construct(CoverageRepository $coverageRepository)
    {
        $this->coverageRepository = $coverageRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('year')
            ->add('make')
            ->add('model')
            ->add('vin')
            ->add('vehicleUsage')
            ->add('primaryUse')
            ->add('annualMilleage')
            ->add('ownership')
            ->add('coverages', EntityType::class, [
                'class' => Coverage::class,
                'choice_label' => 'label',
                'multiple' => true,
                'choices' => $this->coverageRepository->findAll(),
            ])
            ->add('register', SubmitType::class, [
                'label' => 'Save',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
