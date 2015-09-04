<?php

namespace Pequiven\SEIPBundle\Form\Politic;

use Pequiven\SEIPBundle\Form\SeipAbstractForm;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WorkStudyCircleType extends SeipAbstractForm
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$entity = new \Pequiven\SEIPBundle\Entity\DataLoad\PlantReport();
        $entity = $builder->getData();
        
//        $location = $entity->getReportTemplate()->getLocation();
        
        $parametersPreSet = array(
            'label_attr' => array('class' => 'label'),
            "empty_value" => "",
            "attr" => array("class" => "select2 input-large"),
            "disabled" => true,
        );
        
        $parametersToSet = array(
            'label_attr' => array('class' => 'label'),
            "empty_value" => "",
            "attr" => array("class" => "select2 input-large"),
        );
        
        $parametersSelectRegion = array(
                'label_attr' => array('class' => 'label'),
                "empty_value" => "",
                'attr' => array(
                    'class' => "input-xlarge select2"
                ),
                "query_builder" => function (\Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository $repository){
                    return $repository->getQueryAllEnabled();
                }
            );
//        'read_only' => true,
            
        $builder
            ->add("ref", "text", array("label" => "form.ref", "label_attr" => array('class' => 'label'), 'attr' => array('class' => 'input', 'size' => 20)))
            ->add("name", "textarea", array("label" => "form.name_work_study_circle", "label_attr" => array("class" => "label"), "attr" => array("cols" => 50, "rows" => 5, "class" => "input validate[required]")))
            ->add("region",null,$parametersSelectRegion);
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle',
            "translation_domain" => "PequivenSEIPBundle",
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_seipbundle_politic_workstudycircle';
    }
}
