<?php

namespace Pequiven\SEIPBundle\Form\Sip\Center;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Pequiven\SEIPBundle\Model\Sip\Center\CenterReport;

class ReportCenterType extends AbstractType {

    /**
     * @author Maximo Sojo
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
    
        $builder
                ->add('day', 'time', array(                    
                    'widget' => 'choice',
                    'label' => 'Hora',
                    'required' => true,
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        //'format' => 'H:i',
                        'class' => 'input',
                        'style' => 'text-transform:uppercase;',
                        ),
                ))
                ->add('categoria', 'choice', array(
                'label' => 'Categoria ',                
                'choices' => CenterReport::getReportCenter(),
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => 'select2 input-large form-control',
                    'style' => 'width: 300px',                    
                    ),
                'required' => true,
                'empty_value' => 'Seleccione...',
                ))
                ->add('observations', 'textarea', array(
                    'label' => 'Observacion',
                    'required' => false,
                    'label_attr' => array('class' => 'label'),
                    'attr' => array('class' => 'input input-xlarge', 'style' => 'text-transform:uppercase;')))
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
