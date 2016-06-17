<?php

namespace Pequiven\SEIPBundle\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Pequiven\SEIPBundle\Repository\User\FeeStructureRepository;
use Pequiven\MasterBundle\Repository\GerenciaSecondRepository;
use Pequiven\MasterBundle\Repository\GerenciaRepository;
use Pequiven\MasterBundle\Repository\CoordinacionRepository;

class CreateFeeStructureType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $gerencia = $this->gerencia;

        $builder
                ->add('gerenciasecond', 'entity', array(
                    'class' => 'Pequiven\MasterBundle\Entity\GerenciaSecond',
                    'label' => 'Gerencia de 2da Línea',
                    'empty_value' => 'No Aplica',
                    'required' => false,
                    'query_builder' => function(GerenciaSecondRepository $repository) use ($gerencia) {
                        return $repository->getgerenciasSecondQueryBuilder($gerencia);
                    },
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => 'select2 input-large form-control',
                        'style' => 'width: 80%'
                    ),
                    'group_by' => 'gerenciaPrimera'
                ))
                ->add('coordinacion', 'entity', array(
                    'class' => 'Pequiven\MasterBundle\Entity\Coordinacion',
                    'label' => 'Superintendencia o Coordinación',
                    'empty_value' => 'No Aplica',
                    'property' => 'Description',
                    'required' => false,
                    'query_builder' => function(CoordinacionRepository $rep) use ($gerencia) {
                        return $rep->getcoordinacionQueryBuilder($gerencia);
                    },
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => 'select2 input-large form-control',
                        'style' => 'width: 80%'
                    ),
                    'group_by' => 'gerenciaSegunda'
                ))
                ->add('charge', 'text', array(
                    'label' => 'Nombre del Cargo',
                    'required' => true,
                    'label_attr' => array('class' => 'label'),
                    'attr' => array('class' => 'input',
                        'style' => 'width: 75%')
                ))
                ->add('parent', null, array(
                    'label' => 'Jefe o Línea Superior',
                    'empty_value' => 'Seleccione...',
                    'required' => true,
                    'property' => 'Listado_Cargos_Usuarios',
                    'query_builder' => function(FeeStructureRepository $rep) use ($gerencia) {
                        return $rep->getAllfeeStructure($gerencia);
                    },
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => 'select2 input-large form-control',
                        'style' => 'width: 80%'
                    ),
                ))
                ->add('staff', 'checkbox', array(
                    'label' => '¿Es Cargo Auxiliar o de Apoyo?',
                    'required' => false,
                    'value' => 0,
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\User\FeeStructure'));
    }

    public function getName() {
        return 'feestructurecreate';
    }

    public function __construct($gerencia) {
        $this->gerencia = $gerencia;
    }

}
