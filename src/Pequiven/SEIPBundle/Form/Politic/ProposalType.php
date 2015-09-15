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
                'required' => true,
                'attr' => array(
                    'class' => 'select2 input-xlarge form-control',
            )))
            ->add('description', 'textarea', array(
                'label' => 'Propuesta',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => 'input input-large',
                    'cols' => '40',
                    'rows' => '10',
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
