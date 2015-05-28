<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Notification;

use Pequiven\SEIPBundle\Form\DataLoad\Production\CauseFailType;
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
                'type' => new CauseFailType(),
                'allow_add'    => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])
            ->add('externalCauses','collection',[
                'type' => new CauseFailType(),
                'allow_add'    => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])
            ->add('internalCausesMp','collection',[
                'type' => new RawMaterialRequiredType(),
                'allow_add'    => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])
            ->add('externalCausesMp','collection',[
                'type' => new RawMaterialRequiredType(),
                'allow_add'    => true,
                'by_reference' => false,
                'allow_delete' => true,
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
