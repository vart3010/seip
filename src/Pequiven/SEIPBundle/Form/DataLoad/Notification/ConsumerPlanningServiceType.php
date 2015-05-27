<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Notification;

use Pequiven\SEIPBundle\Form\SeipAbstractForm;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConsumerPlanningServiceType extends BaseNotification
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('detailConsumerPlanningServices','collection',[
                'type' => new DetailConsumerPlanningServiceType($this->dateNotification, $this->reportTemplate),
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
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\Service\ConsumerPlanningService',
            "translation_domain" => "PequivenSEIPBundle",
            'cascade_validation' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'service_consumerplanningservice';
    }
}
