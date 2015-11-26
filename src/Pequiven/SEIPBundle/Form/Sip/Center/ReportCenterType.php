<?php

namespace Pequiven\SEIPBundle\Form\Sip\Center;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReportCenterType extends AbstractType {

    /**
     * @author Victor Tortolero
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('observations', 'textarea', array(
                    'label' => 'Observacion',
                    'required' => false,
                    'label_attr' => array('class' => 'label'),
                    'attr' => array('class' => 'input input-xlarge', 'style' => 'text-transform:uppercase;')))
                ->add('hora', 'time', array(
                    'label' => 'Hora',
                    'required' => true,
                    'label_attr' => array('class' => 'label'),
                    'attr' => array('class' => 'input', 'style' => 'text-transform:uppercase;')))
        ;

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\Sip\Center\ReportCentroNotifications'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'report_centro';
    }

}
