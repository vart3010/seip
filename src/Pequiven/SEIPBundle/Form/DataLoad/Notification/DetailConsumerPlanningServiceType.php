<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Notification;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DetailConsumerPlanningServiceType extends BaseNotification
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $parametersDisabled =  $this->getParametersDisabled();
        $paramateretsDays = array(
            'label_attr' => array('class' => 'label'),
            "attr" => array("class" => "input input-large"),
        );
        
        $day = $this->getDayNotification();
        $builder
            
            ->add(sprintf('day%sPlan',$day),null,$parametersDisabled)
            ->add(sprintf('day%sReal',$day),null,$paramateretsDays)
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\Service\DetailConsumerPlanningService',
            "translation_domain" => "PequivenSEIPBundle",
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_seipbundle_dataload_service_detailconsumerplanningservice';
    }
}
