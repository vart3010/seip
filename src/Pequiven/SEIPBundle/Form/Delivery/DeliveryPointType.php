<?php

namespace Pequiven\SEIPBundle\Form\Delivery;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of DelivertPointType
 *
 * @author victor <vart10.30@gmail.com>
 */
class DeliveryPointType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('ref', null, array(
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => "input input-large"
                    ),
                ))
                ->add('descripcion', null, array(
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => "input input-xlarge"
                    ),
                ))
                ->add("warehouse", "entity", array(
                    'label' => 'delivery_point.form.warehouse',
                    'label_attr' => array('class' => 'label'),
                    'class' => 'Pequiven\SEIPBundle\Entity\CEI\Warehouse',
                    'property' => 'descripcion',
                    'translation_domain' => 'Delivery',
                    'attr' => array('class' => 'select2 input-xlarge'),
                ))
                ->add('enabled', null, array(
                    'label' => 'delivery_point.form.enabled',
                    'label_attr' => array('class' => 'label'),
                    "attr" => array("class" => "switch medium mid-margin-right", "data-text-on" => "Si", "data-text-off" => "No"),
                    "required" => false,
                ))
        ;
    }

    /**
     * 
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\Delivery\DeliveryPoint',
            "translation_domain" => "Delivery"
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'pequiven_seipbundle_delivery_deliverypoint';
    }

}
