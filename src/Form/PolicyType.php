<?php

namespace App\Form;

use App\Entity\Policy;
use App\Entity\Vehicle;
use App\Service\Vehicle\VehicleManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PolicyType extends AbstractType
{
    private VehicleManager $vehicleManager;

    public function __construct(VehicleManager $vehicleManager)
    {
        $this->vehicleManager = $vehicleManager;
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
                'label' => false,
                'class' => Vehicle::class,
                'choice_label' => 'label',
                'multiple' => true,
                'choices' => $this->vehicleManager->getVehicles([
                    'hasPolicy' => false,
                ]),
                'by_reference' => false,
            ])
            ->add('status', CheckboxType::class, [
                'label' => 'Is active',
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
