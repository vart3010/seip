<?php

namespace Pequiven\SEIPBundle\Form\HouseSupply\Inventory;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Pequiven\SEIPBundle\Repository\UserRepository;

class houseSupplyInventoryChargeType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('date', 'date', [
                    'label_attr' => array('class' => 'label bold'),
                    'format' => 'd/M/y',
                    'widget' => 'single_text',
                    'label' => 'Fecha de Asignación',
                    'required' => true,
                    'attr' => array('class' => 'input input-large'),
                    'required' => true,
                ])
                ->add('observations', 'textarea', array(
                    'label' => 'Observaciones',
                    'required' => false,
                    'label_attr' => array('class' => 'label'),
                    'attr' => array('class' => 'input input-xlarge', 'style' => 'text-transform:uppercase;')
                        )
                )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\HouseSupply\Inventory\HouseSupplyInventoryCharge'));
    }

    public function getName() {
        return 'HouseSupplyInventoryCharge';
    }

}
