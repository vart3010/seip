<?php

namespace Pequiven\SEIPBundle\Form\Sip;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReportType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('date', 'date', array(
                'label'=>'Fecha',
                'label_attr' => array('class' => 'label'),
                'format' => 'd/M/y',
                'widget' => 'single_text',
                'attr' => array('class' => 'input input-large',               
                'required' => true,)
            ))
        ;
    }
    
//    /**
//     * @param OptionsResolverInterface $resolver
//     */
//    public function setDefaultOptions(OptionsResolverInterface $resolver)
//    {
//        $resolver->setDefaults(array(
//            'data_class' => 'Pequiven\SEIPBundle\Entity\Sip\Center\Assists'
//        ));
//    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sip_report'.'_boo';
    }
}