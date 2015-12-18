<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Notification;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductDetailDailyMonthType extends BaseNotification
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
            // Bruta
            ->add(sprintf('day%sGrossReal',$day),null,array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "input input-mini grossReal"),
            ))
            
//            Neta
            ->add(sprintf('day%sNetReal',$day),null,array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "input input-mini netReal"),
            ))
//          Status del dia
            ->add(sprintf('day%sStatus',$day),'hidden',array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "input input-mini detail-status"),
            ))
            
            //Observacion del dia
            ->add(sprintf('day%sObservation',$day),null,[
                'attr' => [
                    'cols' => '40',
                    'rows' => '10',
                    'maxlength'=>'255',
                    'placeholder' => 'Observaciones. (Máximo 255 Caracteres)'
                ]
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth',
            "translation_domain" => "PequivenSEIPBundle",
            "validation_groups" => array("load"),
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'productdetaildailymonth';
    }
}
