<?php

namespace Pequiven\ArrangementProgramBundle\Form\MovementEmployee;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Pequiven\SEIPBundle\Repository\UserRepository;

class AssignGoalType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('User', 'entity', array(
                    'label' => 'Empleado',
                    'empty_value' => 'Seleccione...',
                    'required' => true,
                    'query_builder' => function(UserRepository $repository) {
                        return $repository->findQueryUsersByCriteria();
                    },
                    'label_attr' => array('class' => 'label'),
                    'class' => 'Pequiven\SEIPBundle\Entity\User',
                    'attr' => array(
                        'class' => 'select2 input-large form-control',
                        'style' => 'width: 300px'
                    ),
                ))


        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\ArrangementProgramBundle\Entity\MovementEmployee\MovementEmployee'));
    }

    public function getName() {
        return 'AssignGoal';
    }

}
