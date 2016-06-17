<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Notification;

use Pequiven\SEIPBundle\Form\DataLoad\Production\CauseFailType;
use Pequiven\SEIPBundle\Form\DataLoad\Production\UnrealizedProductionDay\RawMaterialRequiredType;
use Pequiven\SEIPBundle\Model\CEI\Fail;
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
                'type' => new CauseFailType(Fail::TYPE_FAIL_INTERNAL),
                'allow_add'    => true,
                'by_reference' => false,
                'allow_delete' => true,
                'cascade_validation' => true,
            ])
            ->add('externalCauses','collection',[
                'type' => new CauseFailType(Fail::TYPE_FAIL_EXTERNAL),
                'allow_add'    => true,
                'by_reference' => false,
                'allow_delete' => true,
                'cascade_validation' => true,
            ])
            ->add('internalCausesMp','collection',[
                'type' => new RawMaterialRequiredType(),
                'allow_add'    => true,
                'by_reference' => false,
                'allow_delete' => true,
                'cascade_validation' => true,
            ])
            ->add('externalCausesMp','collection',[
                'type' => new RawMaterialRequiredType(),
                'allow_add'    => true,
                'by_reference' => false,
                'allow_delete' => true,
                'cascade_validation' => true,
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay',
            "translation_domain" => "PequivenSEIPBundle",
            'cascade_validation' => true,
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
