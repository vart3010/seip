<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Production;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DayStopType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('day',"date",array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "input input-large date-day"),
                "widget" => "single_text",
                'format' => 'dd-MM-yyyy',
            ))
            ->add('hours',null,array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "input input-mini"),
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\Production\DayStop'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'daystop';
    }
}
