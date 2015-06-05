<?php

namespace Pequiven\IndicatorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Formulario de edicion del indicador
 */
class IndicatorType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('description', 'textarea', array(
                    'label' => 'form.objetive_statement',
                    'label_attr' => array('class' => 'label'),
                    'translation_domain' =>
                    'PequivenObjetiveBundle',
                    'attr' => array('cols' => 50, 'rows' => 5, 'class' => 'input validate[required]')
                ))
                ->add("weight", null, array(
                    'label' => 'form.weight',
                    'label_attr' => array('class' => 'label'),
                    'translation_domain' => 'PequivenObjetiveBundle',
                    'attr' => array('class' => 'input small-margin-right'),
                ))
                ->add("goal", null, array(
                    'label' => 'form.goal',
                    'label_attr' => array('class' => 'label'),
                    'translation_domain' => 'PequivenObjetiveBundle',
                    'attr' => array('class' => 'input small-margin-right'),
                ))
                ->add("totalPlan", null, array(
                    'label' => 'form.indicator.total_plan',
                    'label_attr' => array('class' => 'label'),
                    'translation_domain' => 'PequivenObjetiveBundle',
                    'attr' => array('class' => 'input small-margin-right'),
                ))
                ->add("frequencyNotificationIndicator", "entity", array(
                    'label' => 'form.frequencyNotification',
                    'label_attr' => array('class' => 'label'),
                    'class' => 'Pequiven\IndicatorBundle\Entity\Indicator\FrequencyNotificationIndicator',
                    'property' => 'description',
                    'translation_domain' => 'PequivenIndicatorBundle',
                    'attr' => array('class' => 'select2 input-xlarge'),
                ))
                ->add("summary", "textarea", array(
                    'label' => 'form.indicator.summary',
                    'label_attr' => array('class' => 'label'),
                    'translation_domain' => 'PequivenObjetiveBundle',
                    'attr' => array('class' => 'input small-margin-right', 'cols' => 50, 'rows' => 5),
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\IndicatorBundle\Entity\Indicator'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'pequiven_indicatorbundle_indicator';
    }

}
