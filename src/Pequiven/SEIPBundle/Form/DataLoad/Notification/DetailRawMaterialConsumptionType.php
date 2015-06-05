<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Notification;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DetailRawMaterialConsumptionType extends BaseNotification
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $day = $this->getDayNotification();
        
        $builder
            
            ->add(sprintf('day%sReal',$day),null,[
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "input input-mini rawMaterialConsumption"),
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\DetailRawMaterialConsumption',
            "translation_domain" => "PequivenSEIPBundle",
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'production_detailrawmaterialconsumption';
    }
}
