<?php

namespace Pequiven\SEIPBundle\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Pequiven\SEIPBundle\Repository\User\FeeStructureRepository;
use Pequiven\MasterBundle\Repository\GerenciaSecondRepository;
use Pequiven\MasterBundle\Repository\GerenciaRepository;

class CreateFeeStructure extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('gerencia', null, array(
                    'query_builder' => function(GerenciaRepository $repository) {
                        return $repository->getgerencias();
                    },
                    'label' => 'Gerencia de 1ra Línea',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => "input-large select2",
                        'style' => 'width: 270px',
                    ),
                    'empty_value' => 'Seleccione...',
                    'required' => true,
                ))
                ->add('gerenciasecond', null, array(
                    'query_builder' => function(GerenciaSecondRepository $repository) {
                        return $repository->getgerenciasSecond();
                    },
                    'label' => 'Gerencia de 2da Línea',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => "input-large select2",
                        'style' => 'width: 270px',
                    ),
                    'empty_value' => 'No Aplica',
                    'required' => false,
                ))
                ->add('charge', 'textarea', array(
                    'label' => 'Observación',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array('class' => 'input input-large')
                ))
                ->add('parent', null, array(
                    'query_builder' => function(FeeStructureRepository $repository) {
                        return $repository->getAll();
                    },
                    'label' => 'Jefe o Línea Superior',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => "input-large select2",
                        'style' => 'width: 270px',
                    ),
                    'empty_value' => 'Seleccione',
                    'required' => True,
                ))
                ->add('staff', null, array(
                    'query_builder' => function(FeeStructureRepository $repository) {
                        return $repository->getAll();
                    },
                    'label' => 'Es Cargo de Apoyo o Asistencia',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => "input-large select2",
                        'style' => 'width: 270px',
                    ),
                    'empty_value' => 'Seleccione',
                    'required' => True,
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\User\FeeStructure'));
    }

    public function getName() {
        return 'fee_structure_create';
    }

}
