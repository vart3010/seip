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
        $data = $builder->getData();
        $typeDetailValue = $data->getIndicator()->getTypeDetailValue();
        if($typeDetailValue == Indicator::TYPE_DETAIL_DAILY_LOAD_PRODUCTION){
            $builder
                ->add('products',null,array(
                    'attr' => array(
                        'class' => 'select'
                    )
                ))
            ;
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\ValueIndicatorConfig'
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
