<?php

namespace Pequiven\SEIPBundle\Form\DataLoad;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Formulario de plantilla de reporte
 */
class ReportTemplateType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null,array(
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "input input-xlarge"
                ),
            ))
            ->add('typeReport',"choice",array(
                "empty_value" => "",
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "select2 input-large"),
                "choices" => \Pequiven\SEIPBundle\Model\DataLoad\ReportTemplate::getTypeReports(),
                "translation_domain" => "PequivenSEIPBundle"
            ))
            ->add("company",null,array(
                'label_attr' => array('class' => 'label'),
                "empty_value" => "",
                'attr' => array(
                    'class' => "input-xlarge select2"
                ),
            ))
            ->add("location",null,array(
                'label_attr' => array('class' => 'label'),
                "empty_value" => "",
                'attr' => array(
                    'class' => "input-xlarge select2"
                ),
            ))
            ->add("plant",null,array(
                'label_attr' => array('class' => 'label'),
                "empty_value" => "",
                'attr' => array(
                    'class' => "input-xlarge select2"
                ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate',
            "translation_domain" => "PequivenSEIPBundle"
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_seipbundle_dataload_reporttemplate';
    }
}
