<?php

namespace Pequiven\SEIPBundle\Form\Sip\Center;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class InventoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('observations', 'textarea', array(
                'label' => 'Observación ',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class'     => 'input input-xlarge autoexpanding',
                    'maxlength' => 1000),
                'required' => true
                ))
            ->add('fecha', 'date', array(
                'label'=>'Fecha ',
                'label_attr' => array('class' => 'label'),
                'format' => 'd/M/y',
                'widget' => 'single_text',
                'attr'   => array('class' => 'input input-large'),
                'required' => true
                ))
            ->add('cantidad', 'text', array(
                'label' => 'Cantidad ',
                'label_attr' => array(
                    'class' => 'label'),
                'attr' => array(                    
                    'class'     => 'input input-large',
                    'onkeypress' => 'return justNumbers(event)',
                    'value'      => '1'
                    ),
                'required'   => true,
                
                ))
            /*->add('material', null, array(
                    'query_builder' => function(\Pequiven\SEIPBundle\Repository\Sip\Centro\MaterialRepository $repository) {
                        return $repository->findQuerySipMaterial();
                    },                               
                    'label' => 'Material',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => "input-large select2",                        
                        'style' => 'width: 270px',                        
                    ),
                    'empty_value' => 'Seleccione...',
                    'required' => true,
                ))          */
            ->add('material','entity',array(
                'label' => 'Material ',
                'label_attr' => array('class' => 'label'),
                'class' => 'Pequiven\SEIPBundle\Entity\Sip\Center\Material',
                'property' => 'description',
                'attr'=> array('class'=> 'select2 input-large form-control'),
                ))
                         
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\Sip\Center\Inventory'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sip_center_inventory';
    }
}