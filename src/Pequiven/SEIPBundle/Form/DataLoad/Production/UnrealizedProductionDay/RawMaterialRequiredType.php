<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Production\UnrealizedProductionDay;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RawMaterialRequiredType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rawMaterial')
            ->add('requiredAmount')
            ->add('amountNotAvailable')
            ->add('unitMeasure')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay\RawMaterialRequired'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_seipbundle_dataload_production_unrealizedproductionday_rawmaterialrequired';
    }
}
