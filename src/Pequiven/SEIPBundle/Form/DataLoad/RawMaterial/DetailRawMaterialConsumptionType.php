<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\RawMaterial;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DetailRawMaterialConsumptionType extends AbstractType
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
            ->add('monthBudget',null,$paramateretsDays)
            ->add('month',"choice",array(
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "select2 input-large"),
                "choices" => \Pequiven\SEIPBundle\Service\ToolService::getMonthsLabels(),
                "empty_value" => "",
            ))
            
            ->add('day1Plan',null,$paramateretsDays)
            ->add('day1Real',null,$paramateretsDays)
            ->add('day2Plan',null,$paramateretsDays)
            ->add('day2Real',null,$paramateretsDays)
            ->add('day3Plan',null,$paramateretsDays)
            ->add('day3Real',null,$paramateretsDays)
            ->add('day4Plan',null,$paramateretsDays)
            ->add('day4Real',null,$paramateretsDays)
            ->add('day5Plan',null,$paramateretsDays)
            ->add('day5Real',null,$paramateretsDays)
            ->add('day6Plan',null,$paramateretsDays)
            ->add('day6Real',null,$paramateretsDays)
            ->add('day7Plan',null,$paramateretsDays)
            ->add('day7Real',null,$paramateretsDays)
            ->add('day8Plan',null,$paramateretsDays)
            ->add('day8Real',null,$paramateretsDays)
            ->add('day9Plan',null,$paramateretsDays)
            ->add('day9Real',null,$paramateretsDays)
            ->add('day10Plan',null,$paramateretsDays)
            ->add('day10Real',null,$paramateretsDays)
            ->add('day11Plan',null,$paramateretsDays)
            ->add('day11Real',null,$paramateretsDays)
            ->add('day12Plan',null,$paramateretsDays)
            ->add('day12Real',null,$paramateretsDays)
            ->add('day13Plan',null,$paramateretsDays)
            ->add('day13Real',null,$paramateretsDays)
            ->add('day14Plan',null,$paramateretsDays)
            ->add('day14Real',null,$paramateretsDays)
            ->add('day15Plan',null,$paramateretsDays)
            ->add('day15Real',null,$paramateretsDays)
            ->add('day16Plan',null,$paramateretsDays)
            ->add('day16Real',null,$paramateretsDays)
            ->add('day17Plan',null,$paramateretsDays)
            ->add('day17Real',null,$paramateretsDays)
            ->add('day18Plan',null,$paramateretsDays)
            ->add('day18Real',null,$paramateretsDays)
            ->add('day19Plan',null,$paramateretsDays)
            ->add('day19Real',null,$paramateretsDays)
            ->add('day20Plan',null,$paramateretsDays)
            ->add('day20Real',null,$paramateretsDays)
            ->add('day21Plan',null,$paramateretsDays)
            ->add('day21Real',null,$paramateretsDays)
            ->add('day22Plan',null,$paramateretsDays)
            ->add('day22Real',null,$paramateretsDays)
            ->add('day23Plan',null,$paramateretsDays)
            ->add('day23Real',null,$paramateretsDays)
            ->add('day24Plan',null,$paramateretsDays)
            ->add('day24Real',null,$paramateretsDays)
            ->add('day25Plan',null,$paramateretsDays)
            ->add('day25Real',null,$paramateretsDays)
            ->add('day26Plan',null,$paramateretsDays)
            ->add('day26Real',null,$paramateretsDays)
            ->add('day27Plan',null,$paramateretsDays)
            ->add('day27Real',null,$paramateretsDays)
            ->add('day28Plan',null,$paramateretsDays)
            ->add('day28Real',null,$paramateretsDays)
            ->add('day29Plan',null,$paramateretsDays)
            ->add('day29Real',null,$paramateretsDays)
            ->add('day30Plan',null,$paramateretsDays)
            ->add('day30Real',null,$paramateretsDays)
            ->add('day31Plan',null,$paramateretsDays)
            ->add('day31Real',null,$paramateretsDays)
                
            ->add('ranges',"collection",array(
                'label_attr' => array('class' => 'label'),
                "type" => new RangeType(),
                "allow_add"    => true,
                'by_reference' => false,
                'allow_delete' => true,
            ))
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
        return 'pequiven_seipbundle_dataload_production_detailrawmaterialconsumption';
    }
}
