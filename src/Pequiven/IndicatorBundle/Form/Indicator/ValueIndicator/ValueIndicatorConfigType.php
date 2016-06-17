<?php

namespace Pequiven\IndicatorBundle\Form\Indicator\ValueIndicator;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Pequiven\IndicatorBundle\Entity\Indicator;

class ValueIndicatorConfigType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        //Se comento por error en la busqueda de ajax no esta seteado el indicador
//        $data = $builder->getData();
//        $typeDetailValue = $data->getIndicator()->getTypeDetailValue();
//        if($typeDetailValue == Indicator::TYPE_DETAIL_DAILY_LOAD_PRODUCTION){
        $emptyValue = "Seleccione";
//        $period = $this->getPeriodService()->getPeriodActive();
        $period = 3;
//            $builder
//                ->add('products','entity',array(
//                    'label_attr' => array('class' => 'label bold'),
//                    'class' => 'Pequiven\SEIPBundle\Entity\CEI\Product',
//                    'property' => 'name',
//                    'required' => true,
//                    'empty_value' => $emptyValue,
//                    'translation_domain' => 'PequivenSEIPBundle',
//                    'attr' => array('class' => 'select2 input-xlarge'),
//                    'multiple' => true,
//                    'query_builder' => function (\Pequiven\SEIPBundle\Repository\CEI\ProductRepository $qb)
//                        {
//                            return $qb->getQueryAllComponents();
//                        }
//                        ))
//                                    ;

//                ->add('products','tecno_ajax_autocomplete',array(
//                    'label' => 'form.products',
//                    'entity_alias' => 'products_alias',
//                    'label_attr' => array('class' => 'label'),
//                    'attr' => array(
//                        "class" => "input input-xlarge validate[required]"
//                    ),
//                    "property" => array("name"),
//                    "multiple" => true,
//                    "callback" => function (\Pequiven\SEIPBundle\Repository\CEI\ProductRepository $qb)
//                    {
//                        return $qb->getQueryAllComponents();
//                    }
//                ))
                    
                        
            $builder
                ->add('productReports','entity',array(
                    'label_attr' => array('class' => 'label bold'),
                    'class' => 'Pequiven\SEIPBundle\Entity\DataLoad\ProductReport',
                    'property' => 'name',
                    'required' => false,
                    'empty_value' => $emptyValue,
                    'translation_domain' => 'PequivenSEIPBundle',
                    'attr' => array('class' => 'select2 input-xlarge'),
                    'multiple' => true,
                    "query_builder" => function (\Pequiven\SEIPBundle\Repository\DataLoad\ProductReportRepository $repository) use ($period){
                        return $repository->findQueryByPeriod($period);
                    },
                        ))
                        ;
//        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\ValueIndicatorConfig',
            'translation_domain' => 'PequivenIndicatorBundle',
        ));
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_indicatorbundle_indicator_valueindicator_valueindicatorconfig';
    }
}
