<?php

namespace Pequiven\SEIPBundle\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Pequiven\SEIPBundle\Repository\UserRepository;
use Pequiven\SEIPBundle\Model\User\MovementFeeStructure;

class MovementFeeStructureInType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
            ->add('date', 'date', array(
                'label'=>'Fecha',
                'label_attr' => array('class' => 'label'),
                'format' => 'd/M/y',
                'widget' => 'single_text',
                'attr' => array('class' => 'input input-large')               
            ))
            ->add('cause', 'choice', array(
                'label' => 'Causa ',                
                'choices' => MovementFeeStructure::getCausein(),
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => 'select2 input-large form-control',
                    'style' => 'width: 300px',
                    ),
                'required' => true,
                'empty_value' => 'Seleccione...',
            ))
            ->add('observations', 'textarea', array(
                'label'=>'Observación',
                'label_attr' => array('class' => 'label'),
                'required' => false,
                'attr' => array('class' => 'input input-large')               
            ))
            ->add('User', null, array(
                    'query_builder' => function(\Pequiven\SEIPBundle\Repository\UserRepository $repository) {
                        return $repository->findQueryUsersByCriteria();
                    },                               
                    'label' => 'Personal',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => "input-large select2",                        
                        'style' => 'width: 270px',                        
                    ),
                    'empty_value' => 'Seleccione...',
                    'required' => true,
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\User\MovementFeeStructure'));
    }

    public function getName() {
        return 'fee_structure_add';
    }

}
