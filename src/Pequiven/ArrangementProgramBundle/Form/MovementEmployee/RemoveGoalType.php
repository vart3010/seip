<?php

namespace Pequiven\ArrangementProgramBundle\Form\MovementEmployee;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Pequiven\SEIPBundle\Repository\UserRepository;
use Pequiven\ArrangementProgramBundle\Entity\Goal;

class RemoveGoalType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('User', null, array(
                    'query_builder' => function(UserRepository $repository) {
                        return $repository->findQuerytoRemoveAssingedGoal(13451);
                    },
                    'label' => 'Empleados Asignados',
                    'empty_value' => 'Seleccione...',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => "select2 input-large form-control",
                        'style' => 'width: 270px',
                    ),
                    'required' => true,
                ))


        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\ArrangementProgramBundle\Entity\MovementEmployee\MovementEmployee'));
    }

    public function getName() {
        return 'RemoveGoal';
    }

    protected $idGoal;

    public function __construct(Goal $id) {
        var_dump($id);
        die();
        $this->goal = $id;
    }

}
