<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Notification;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UnrealizedProductionType extends BaseNotification
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $day = $this->getDayNotification();
        $paramateretsDays = $this->getParametersStandard();
        $builder
            ->add(sprintf('day%s',$day),null,array(
            'label_attr' => array('class' => 'label'),
            "attr" => array("class" => "input input-mini pnrClass",'min' => '0'),
            'constraints' => array(
                new \Symfony\Component\Validator\Constraints\Range(array(
                    'min' => 0,
                ))
            ),
            ))
            ->add(sprintf('day%sDetails',$day),new UnrealizedProductionDayType($this->dateNotification, $this->reportTemplate))
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
