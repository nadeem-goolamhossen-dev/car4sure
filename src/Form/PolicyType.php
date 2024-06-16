<?php

namespace App\Form;

use App\Entity\Policy;
use App\Entity\Vehicle;
use App\Repository\VehicleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PolicyType extends AbstractType
{
    private VehicleRepository $vehicleRepository;

    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', TextType::class, [
                'label' => 'Policy type'
            ])
            ->add('effectiveDate', null, [
                'widget' => 'single_text',
            ])
            ->add('expirationDate', null, [
                'widget' => 'single_text',
            ])
            ->add('vehicles', EntityType::class, [
                'class' => Vehicle::class,
                'choice_label' => 'label',
                'multiple' => true,
                'choices' => $this->vehicleRepository->findAll(),
            ])
            ->add('status', CheckboxType::class, [
                'required' => false,
                'label_attr' => ['class' => 'form-check-label'],
                'attr' => ['class' => 'form-check-input'],
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
            'data_class' => Policy::class,
        ]);
    }
}
