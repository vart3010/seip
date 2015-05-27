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
        $parametersDisabled = $this->getParametersDisabled();
        
        $builder
            ->add('service',null,$parametersDisabled)
            ->add('detailConsumerPlanningServices','collection',[
                'type' => new DetailConsumerPlanningServiceType($this->dateNotification, $this->reportTemplate)
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
