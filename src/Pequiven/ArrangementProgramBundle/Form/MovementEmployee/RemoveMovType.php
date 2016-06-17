<?php

namespace Pequiven\ArrangementProgramBundle\Form\MovementEmployee;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Pequiven\SEIPBundle\Repository\UserRepository;
use Pequiven\ArrangementProgramBundle\Entity\Goal;
use Pequiven\ArrangementProgramBundle\Model\MovementEmployee;

class RemoveMovType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $id = $this->id;
        $post_mortem = $this->post_mortem;
        $type = $this->type;

        $builder
                ->add('date', 'date', [
                    'label_attr' => array('class' => 'label bold'),
                    'format' => 'd/M/y',
                    'widget' => 'single_text',
                    'label' => 'Fecha de Retiro de la Meta',
                    'required' => true,
                    'attr' => array('class' => 'input input-large'),
                    'required' => true,
        ]);

        if ($post_mortem == true) {
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
            ));
        } else {

            if ($type == 'Goal') {
                $builder
                        ->add('User', null, array(
                            'query_builder' => function(UserRepository $repository) use ($id) {
                                return $repository->findQuerytoRemoveAssingedGoal($id);
                            },
                            'label' => 'Empleados Asignados',
                            'empty_value' => 'Seleccione...',
                            'label_attr' => array('class' => 'label'),
                            'attr' => array(
                                'class' => "select2 input-large form-control",
                                'style' => 'width: 270px',
                            ),
                            'required' => true,
                ));
            }

            if ($type == 'AP') {
                $builder
                        ->add('User', null, array(
                            'query_builder' => function(UserRepository $repository) use ($id) {
                                return $repository->findQuerytoRemoveAssingedAP($id);
                            },
                            'label' => 'Empleados Asignados',
                            'empty_value' => 'Seleccione...',
                            'label_attr' => array('class' => 'label'),
                            'attr' => array(
                                'class' => "select2 input-large form-control",
                                'style' => 'width: 270px',
                            ),
                            'required' => true,
                ));
            }
        }

        $builder
                ->add('cause', 'choice', array(
                    'label' => 'Motivo o Causa',
                    'required' => true,
                    'choices' => MovementEmployee::getCauseout(),
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => 'select2 input-large form-control',
                        'style' => 'width: 300px')
                        )
                )
                ->add('observations', 'textarea', array(
                    'label' => 'Observaciones',
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
        return 'RemoveMov';
    }

    protected $id;

    public function __construct($id, $post_mortem, $type) {
        $this->id = $id;
        $this->post_mortem = $post_mortem;
        $this->type = $type;
    }

}
