<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Notification;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Formulario de plantilla de reporte
 */
class ReportTemplateType extends BaseNotification
{
    

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add("plantReports",'collection',array(
               'type' => new PlantReportType($this->dateNotification,  $this->reportTemplate),
               'cascade_validation' => true,
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
            "translation_domain" => "PequivenSEIPBundle",
            'cascade_validation' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'reporttemplate';
    }
}
