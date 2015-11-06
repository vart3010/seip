<?php

namespace Pequiven\ArrangementProgramBundle\Form\MovementEmployee;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Pequiven\SEIPBundle\Repository\UserRepository;
use Pequiven\ArrangementProgramBundle\Model\MovementEmployee;

class AssignMovType extends AbstractType {

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
                ->add('cause', 'choice', array(
                    'label' => 'Motivo o Causa',
                    'required' => true,
                    'choices' => MovementEmployee::getCausein(),
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => 'select2 input-large form-control',
                        'style' => 'width: 300px')
                        )
                )
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
            'data_class' => 'Pequiven\ArrangementProgramBundle\Entity\MovementEmployee\MovementEmployee'));
    }

    public function getName() {
        return 'AssignMov';
    }

}
