<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Production;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductDetailDailyMonthType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $paramateretsDays = array(
            'label_attr' => array('class' => 'label'),
            "attr" => array("class" => "input input-large"),
        );
        $builder
            ->add('month',"choice",array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "select2 input-large"),
                "choices" => \Pequiven\SEIPBundle\Service\ToolService::getMonthsLabels(),
                "empty_value" => "",
            ))
            // Bruta
            ->add('day1GrossPlan',null,$paramateretsDays)
            ->add('day1GrossReal',null,$paramateretsDays)
            ->add('day2GrossPlan',null,$paramateretsDays)
            ->add('day2GrossReal',null,$paramateretsDays)
            ->add('day3GrossPlan',null,$paramateretsDays)
            ->add('day3GrossReal',null,$paramateretsDays)
            ->add('day4GrossPlan',null,$paramateretsDays)
            ->add('day4GrossReal',null,$paramateretsDays)
            ->add('day5GrossPlan',null,$paramateretsDays)
            ->add('day5GrossReal',null,$paramateretsDays)
            ->add('day6GrossPlan',null,$paramateretsDays)
            ->add('day6GrossReal',null,$paramateretsDays)
            ->add('day7GrossPlan',null,$paramateretsDays)
            ->add('day7GrossReal',null,$paramateretsDays)
            ->add('day8GrossPlan',null,$paramateretsDays)
            ->add('day8GrossReal',null,$paramateretsDays)
            ->add('day9GrossPlan',null,$paramateretsDays)
            ->add('day9GrossReal',null,$paramateretsDays)
            ->add('day10GrossPlan',null,$paramateretsDays)
            ->add('day10GrossReal',null,$paramateretsDays)
            ->add('day11GrossPlan',null,$paramateretsDays)
            ->add('day11GrossReal',null,$paramateretsDays)
            ->add('day12GrossPlan',null,$paramateretsDays)
            ->add('day12GrossReal',null,$paramateretsDays)
            ->add('day13GrossPlan',null,$paramateretsDays)
            ->add('day13GrossReal',null,$paramateretsDays)
            ->add('day14GrossPlan',null,$paramateretsDays)
            ->add('day14GrossReal',null,$paramateretsDays)
            ->add('day15GrossPlan',null,$paramateretsDays)
            ->add('day15GrossReal',null,$paramateretsDays)
            ->add('day16GrossPlan',null,$paramateretsDays)
            ->add('day16GrossReal',null,$paramateretsDays)
            ->add('day17GrossPlan',null,$paramateretsDays)
            ->add('day17GrossReal',null,$paramateretsDays)
            ->add('day18GrossPlan',null,$paramateretsDays)
            ->add('day18GrossReal',null,$paramateretsDays)
            ->add('day19GrossPlan',null,$paramateretsDays)
            ->add('day19GrossReal',null,$paramateretsDays)
            ->add('day20GrossPlan',null,$paramateretsDays)
            ->add('day20GrossReal',null,$paramateretsDays)
            ->add('day21GrossPlan',null,$paramateretsDays)
            ->add('day21GrossReal',null,$paramateretsDays)
            ->add('day22GrossPlan',null,$paramateretsDays)
            ->add('day22GrossReal',null,$paramateretsDays)
            ->add('day23GrossPlan',null,$paramateretsDays)
            ->add('day23GrossReal',null,$paramateretsDays)
            ->add('day24GrossPlan',null,$paramateretsDays)
            ->add('day24GrossReal',null,$paramateretsDays)
            ->add('day25GrossPlan',null,$paramateretsDays)
            ->add('day25GrossReal',null,$paramateretsDays)
            ->add('day26GrossPlan',null,$paramateretsDays)
            ->add('day26GrossReal',null,$paramateretsDays)
            ->add('day27GrossPlan',null,$paramateretsDays)
            ->add('day27GrossReal',null,$paramateretsDays)
            ->add('day28GrossPlan',null,$paramateretsDays)
            ->add('day28GrossReal',null,$paramateretsDays)
            ->add('day29GrossPlan',null,$paramateretsDays)
            ->add('day29GrossReal',null,$paramateretsDays)
            ->add('day30GrossPlan',null,$paramateretsDays)
            ->add('day30GrossReal',null,$paramateretsDays)
            ->add('day31GrossPlan',null,$paramateretsDays)
            ->add('day31GrossReal',null,$paramateretsDays)
//            Neta
            ->add('day1NetPlan',null,$paramateretsDays)
            ->add('day1NetReal',null,$paramateretsDays)
            ->add('day2NetPlan',null,$paramateretsDays)
            ->add('day2NetReal',null,$paramateretsDays)
            ->add('day3NetPlan',null,$paramateretsDays)
            ->add('day3NetReal',null,$paramateretsDays)
            ->add('day4NetPlan',null,$paramateretsDays)
            ->add('day4NetReal',null,$paramateretsDays)
            ->add('day5NetPlan',null,$paramateretsDays)
            ->add('day5NetReal',null,$paramateretsDays)
            ->add('day6NetPlan',null,$paramateretsDays)
            ->add('day6NetReal',null,$paramateretsDays)
            ->add('day7NetPlan',null,$paramateretsDays)
            ->add('day7NetReal',null,$paramateretsDays)
            ->add('day8NetPlan',null,$paramateretsDays)
            ->add('day8NetReal',null,$paramateretsDays)
            ->add('day9NetPlan',null,$paramateretsDays)
            ->add('day9NetReal',null,$paramateretsDays)
            ->add('day10NetPlan',null,$paramateretsDays)
            ->add('day10NetReal',null,$paramateretsDays)
            ->add('day11NetPlan',null,$paramateretsDays)
            ->add('day11NetReal',null,$paramateretsDays)
            ->add('day12NetPlan',null,$paramateretsDays)
            ->add('day12NetReal',null,$paramateretsDays)
            ->add('day13NetPlan',null,$paramateretsDays)
            ->add('day13NetReal',null,$paramateretsDays)
            ->add('day14NetPlan',null,$paramateretsDays)
            ->add('day14NetReal',null,$paramateretsDays)
            ->add('day15NetPlan',null,$paramateretsDays)
            ->add('day15NetReal',null,$paramateretsDays)
            ->add('day16NetPlan',null,$paramateretsDays)
            ->add('day16NetReal',null,$paramateretsDays)
            ->add('day17NetPlan',null,$paramateretsDays)
            ->add('day17NetReal',null,$paramateretsDays)
            ->add('day18NetPlan',null,$paramateretsDays)
            ->add('day18NetReal',null,$paramateretsDays)
            ->add('day19NetPlan',null,$paramateretsDays)
            ->add('day19NetReal',null,$paramateretsDays)
            ->add('day20NetPlan',null,$paramateretsDays)
            ->add('day20NetReal',null,$paramateretsDays)
            ->add('day21NetPlan',null,$paramateretsDays)
            ->add('day21NetReal',null,$paramateretsDays)
            ->add('day22NetPlan',null,$paramateretsDays)
            ->add('day22NetReal',null,$paramateretsDays)
            ->add('day23NetPlan',null,$paramateretsDays)
            ->add('day23NetReal',null,$paramateretsDays)
            ->add('day24NetPlan',null,$paramateretsDays)
            ->add('day24NetReal',null,$paramateretsDays)
            ->add('day25NetPlan',null,$paramateretsDays)
            ->add('day25NetReal',null,$paramateretsDays)
            ->add('day26NetPlan',null,$paramateretsDays)
            ->add('day26NetReal',null,$paramateretsDays)
            ->add('day27NetPlan',null,$paramateretsDays)
            ->add('day27NetReal',null,$paramateretsDays)
            ->add('day28NetPlan',null,$paramateretsDays)
            ->add('day28NetReal',null,$paramateretsDays)
            ->add('day29NetPlan',null,$paramateretsDays)
            ->add('day29NetReal',null,$paramateretsDays)
            ->add('day30NetPlan',null,$paramateretsDays)
            ->add('day30NetReal',null,$paramateretsDays)
            ->add('day31NetPlan',null,$paramateretsDays)
            ->add('day31NetReal',null,$paramateretsDays)
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
        return 'pequiven_seipbundle_dataload_production_productdetaildailymonth';
    }
}
