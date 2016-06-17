<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Inventory;

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
            ->add('day1',null,$paramateretsDays)
            ->add('day2',null,$paramateretsDays)
            ->add('day3',null,$paramateretsDays)
            ->add('day4',null,$paramateretsDays)
            ->add('day5',null,$paramateretsDays)
            ->add('day6',null,$paramateretsDays)
            ->add('day7',null,$paramateretsDays)
            ->add('day8',null,$paramateretsDays)
            ->add('day9',null,$paramateretsDays)
            ->add('day10',null,$paramateretsDays)
            ->add('day11',null,$paramateretsDays)
            ->add('day12',null,$paramateretsDays)
            ->add('day13',null,$paramateretsDays)
            ->add('day14',null,$paramateretsDays)
            ->add('day15',null,$paramateretsDays)
            ->add('day16',null,$paramateretsDays)
            ->add('day17',null,$paramateretsDays)
            ->add('day18',null,$paramateretsDays)
            ->add('day19',null,$paramateretsDays)
            ->add('day20',null,$paramateretsDays)
            ->add('day21',null,$paramateretsDays)
            ->add('day22',null,$paramateretsDays)
            ->add('day23',null,$paramateretsDays)
            ->add('day24',null,$paramateretsDays)
            ->add('day25',null,$paramateretsDays)
            ->add('day26',null,$paramateretsDays)
            ->add('day27',null,$paramateretsDays)
            ->add('day28',null,$paramateretsDays)
            ->add('day29',null,$paramateretsDays)
            ->add('day30',null,$paramateretsDays)
            ->add('day31',null,$paramateretsDays)
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\Inventory\Inventory',
            "translation_domain" => "PequivenSEIPBundle",
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_seipbundle_dataload_inventory_inventory';
    }
}
