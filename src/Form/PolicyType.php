<?php

namespace App\Form;

use App\Entity\Person;
use App\Entity\Policy;
use App\Entity\Vehicle;
use App\Repository\PolicyRepository;
use App\Service\Person\PersonManager;
use App\Service\Vehicle\VehicleManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PolicyType extends AbstractType
{
    /**
     * @var PersonManager
     */
    private PersonManager $personManager;

    /**
     * @var VehicleManager
     */
    private VehicleManager $vehicleManager;

    /**
     * @var PolicyRepository
     */
    private PolicyRepository $policyRepository;

    /**
     * Constructor
     *
     * @param PersonManager $personManager
     * @param VehicleManager $vehicleManager
     */
    public function __construct(
        PersonManager $personManager,
        VehicleManager $vehicleManager,
        PolicyRepository $policyRepository
    )
    {
        $this->personManager = $personManager;
        $this->vehicleManager = $vehicleManager;
        $this->policyRepository = $policyRepository;
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
        //$policy = $options['data'] ? $options['data'] : null;
        /*$effectiveDate = (new DateTime())->add(new DateInterval('P1D'))->setTime(0, 0, 0);

        if ($policy && !is_null($policy->getId())) {
            $effectiveDate = $policy->getEffectiveDate();
        }*/

        $builder
            ->add('type', TextType::class, [
                'label' => 'Policy type'
            ])
            ->add('effectiveDate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('expirationDate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('holder', EntityType::class, [
                'class' => Person::class,
                'choice_label' => 'fullname',
            ])
            ->add('status', CheckboxType::class, [
                'label' => 'Is active',
                'required' => false,
                'label_attr' => ['class' => 'form-check-label'],
                'attr' => ['class' => 'form-check-input'],
            ])
            ->add('drivers', EntityType::class, [
                'label' => false,
                'class' => Person::class,
                'choice_label' => 'fullname',
                'multiple' => true,
                'by_reference' => false,
            ])
            ->add('vehicles', EntityType::class, [
                'label' => false,
                'class' => Vehicle::class,
                'choice_label' => 'label',
                'multiple' => true,
                'choices' => $this->vehicleManager->getVehicles(),
                'by_reference' => false,
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
     * Configurations
     *
     * @param OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Policy::class,
        ]);
    }
}
