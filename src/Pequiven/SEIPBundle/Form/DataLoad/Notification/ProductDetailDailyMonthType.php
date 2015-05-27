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
        $paramateretsDaysDisabled = $this->getParametersDisabled();
        
        $builder
            // Bruta
//            ->add(sprintf("day%sGrossPlan",$day),null,$paramateretsDaysDisabled)
            ->add(sprintf('day%sGrossReal',$day),null,$paramateretsDays)
            
//            Neta
//            ->add(sprintf('day%sNetPlan',$day),null,$paramateretsDaysDisabled)
            ->add(sprintf('day%sNetReal',$day),null,$paramateretsDays)
            
            //Observacion del dia
            ->add(sprintf('day%sObservation',$day),null,[
                'attr' => [
                    'cols' => '40',
                    'rows' => '10',
                    'placeholder' => 'Observaciones...'
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
