<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Notification;

use Pequiven\SEIPBundle\Form\DataLoad\Production\UnrealizedProductionDay\RawMaterialRequiredType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UnrealizedProductionDayType extends BaseNotification
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('internalCauses','collection',[
                'type' => new \Pequiven\SEIPBundle\Form\DataLoad\Production\CauseFailType(),
            ])
            ->add('externalCauses','collection',[
                'type' => new \Pequiven\SEIPBundle\Form\DataLoad\Production\CauseFailType(),
            ])
            ->add('internalCauseMp','collection',[
                'type' => new RawMaterialRequiredType()
            ])
            ->add('externalCauseMp','collection',[
                'type' => new RawMaterialRequiredType()
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProduction',
            "translation_domain" => "PequivenSEIPBundle",
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'production_unrealizedproduction';
    }
}
