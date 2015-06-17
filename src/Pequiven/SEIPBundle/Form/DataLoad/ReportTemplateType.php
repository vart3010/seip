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
        $entity = $builder->getData();
        $disabled = true;
        if($entity !== null && $entity->getId() > 0){
            $disabled = false;
        }
        $builder
            ->add('name',null,array(
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "input input-xlarge"
                ),
            ))
            ->add("company",null,array(
                'label_attr' => array('class' => 'label'),
                "empty_value" => "",
                'attr' => array(
                    'class' => "input-xlarge select2"
                ),
                "query_builder" => function (\Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository $repository){
                    return $repository->getQueryAllEnabled();
                }
            ))
            ->add("location",null,array(
                'label_attr' => array('class' => 'label'),
                "empty_value" => "",
                'attr' => array(
                    'class' => "input-xlarge select2"
                ),
                "query_builder" => function (\Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository $repository){
                    return $repository->getQueryAllEnabled();
                }
            ))
            ->add("region",null,array(
                'label_attr' => array('class' => 'label'),
                "empty_value" => "",
                'attr' => array(
                    'class' => "input-xlarge select2"
                ),
                "query_builder" => function (\Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository $repository){
                    return $repository->getQueryAllEnabled();
                }
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
