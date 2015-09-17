<?php

namespace Pequiven\SEIPBundle\Form\Politic;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MeetingType extends AbstractType {

    /**
     * @author Victor Tortolero
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('date', 'date', [
                    'label_attr' => array('class' => 'label bold'),
                    'format' => 'd/M/y',
                    'widget' => 'single_text',
                    'label' => 'Fecha Reunión',
                    'attr' => array('class' => 'input input-large'),
                    'required' => true,
                ])
                ->add('place', 'textarea', array(
                    'label' => 'Lugar de Reunión',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array('class' => 'input input-xlarge')))
                ->add('subject', 'textarea', array(
                    'label' => 'Tema de la Reunión',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array('class' => 'input input-xlarge')))
                ->add('observation', 'textarea', array(
                    'label' => 'Observaciones',
                    'required' => false,
                    'label_attr' => array('class' => 'label'),
                    'attr' => array('class' => 'input input-xlarge')))

        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\Politic\Meeting'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'meeting_data';
    }

}
