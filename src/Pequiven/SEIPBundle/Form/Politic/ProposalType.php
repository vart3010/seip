<?php

namespace Pequiven\SEIPBundle\Form\Politic;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProposalType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('lineStrategic', 'entity', array(
                    'label' => 'Línea Estratégica',
                    'label_attr' => array('class' => 'label'),
                    'class' => 'Pequiven\MasterBundle\Entity\LineStrategic',
                    'property' => 'descriptionSelect',
                    'empty_value' => 'Seleccione',
                    'mapped' => false,
                    'required' => true,
                    'attr' => array(
                        'class' => 'select2 input-xlarge form-control',
            )))
                ->add('description1', 'textarea', array(
                    'label' => 'Propuesta 1',
                    'label_attr' => array(
                        'class' => 'label'
                    ),
                    'mapped' => false,
                    'required' => false,
                    'attr' => array(
//                    'class' => 'input input-large',
                        'cols' => '80',
                        'rows' => '10',
                        'style' => 'text-transform:uppercase'
            )))
                ->add('description2', 'textarea', array(
                    'label' => 'Propuesta 2',
                    'label_attr' => array(
                        'class' => 'label',
                    ),
                    'mapped' => false,
                    'required' => false,
                    'attr' => array(
                        'cols' => '80',
                        'rows' => '10',
                        'style' => 'text-transform:uppercase'
            )))
                ->add('description3', 'textarea', array(
                    'label' => 'Propuesta 3',
                    'label_attr' => array(
                        'class' => 'label',
                    ),
                    'mapped' => false,
                    'required' => false,
                    'attr' => array(
                        'cols' => '80',
                        'rows' => '10',
                        'style' => 'text-transform:uppercase'
            )))
                ->add('description4', 'textarea', array(
                    'label' => 'Propuesta 4',
                    'label_attr' => array(
                        'class' => 'label',
                    ),
                    'mapped' => false,
                    'required' => false,
                    'attr' => array(
                        'cols' => '80',
                        'rows' => '10',
                        'style' => 'text-transform:uppercase'
            )))
                ->add('description5', 'textarea', array(
                    'label' => 'Propuesta 5',
                    'label_attr' => array(
                        'class' => 'label',
                    ),
                    'mapped' => false,
                    'required' => false,
                    'attr' => array(
                        'cols' => '80',
                        'rows' => '10',
                        'style' => 'text-transform:uppercase'
            )))
                ->add('description6', 'textarea', array(
                    'label' => 'Propuesta 6',
                    'label_attr' => array(
                        'class' => 'label',
                    ),
                    'mapped' => false,
                    'required' => false,
                    'attr' => array(
                        'cols' => '80',
                        'rows' => '10',
                        'style' => 'text-transform:uppercase'
            )))
                ->add('description7', 'textarea', array(
                    'label' => 'Propuesta 7',
                    'label_attr' => array(
                        'class' => 'label',
                    ),
                    'mapped' => false,
                    'required' => false,
                    'attr' => array(
                        'cols' => '80',
                        'rows' => '10',
                        'style' => 'text-transform:uppercase'
            )))
                ->add('description8', 'textarea', array(
                    'label' => 'Propuesta 8',
                    'label_attr' => array(
                        'class' => 'label',
                    ),
                    'mapped' => false,
                    'required' => false,
                    'attr' => array(
                        'cols' => '80',
                        'rows' => '10',
                        'style' => 'text-transform:uppercase'
            )))
                ->add('description9', 'textarea', array(
                    'label' => 'Propuesta 9',
                    'label_attr' => array(
                        'class' => 'label',
                    ),
                    'mapped' => false,
                    'required' => false,
                    'attr' => array(
                        'cols' => '80',
                        'rows' => '10',
                        'style' => 'text-transform:uppercase'
            )))
                ->add('description10', 'textarea', array(
                    'label' => 'Propuesta 10',
                    'label_attr' => array(
                        'class' => 'label',
                    ),
                    'mapped' => false,
                    'required' => false,
                    'attr' => array(
                        'cols' => '80',
                        'rows' => '10',
                        'style' => 'text-transform:uppercase'
            )))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\Politic\Proposal'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'proposal_data';
    }

}
