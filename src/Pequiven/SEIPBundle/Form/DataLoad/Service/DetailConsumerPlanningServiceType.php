<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Service;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DetailConsumerPlanningServiceType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('monthBudget')
            ->add('month')
            ->add('totalPlan')
            ->add('totalReal')
            ->add('percentage')
            ->add('day1Plan')
            ->add('day1Real')
            ->add('day2Plan')
            ->add('day2Real')
            ->add('day3Plan')
            ->add('day3Real')
            ->add('day4Plan')
            ->add('day4Real')
            ->add('day5Plan')
            ->add('day5Real')
            ->add('day6Plan')
            ->add('day6Real')
            ->add('day7Plan')
            ->add('day7Real')
            ->add('day8Plan')
            ->add('day8Real')
            ->add('day9Plan')
            ->add('day9Real')
            ->add('day10Plan')
            ->add('day10Real')
            ->add('day11Plan')
            ->add('day11Real')
            ->add('day12Plan')
            ->add('day12Real')
            ->add('day13Plan')
            ->add('day13Real')
            ->add('day14Plan')
            ->add('day14Real')
            ->add('day15Plan')
            ->add('day15Real')
            ->add('day16Plan')
            ->add('day16Real')
            ->add('day17Plan')
            ->add('day17Real')
            ->add('day18Plan')
            ->add('day18Real')
            ->add('day19Plan')
            ->add('day19Real')
            ->add('day20Plan')
            ->add('day20Real')
            ->add('day21Plan')
            ->add('day21Real')
            ->add('day22Plan')
            ->add('day22Real')
            ->add('day23Plan')
            ->add('day23Real')
            ->add('day24Plan')
            ->add('day24Real')
            ->add('day25Plan')
            ->add('day25Real')
            ->add('day26Plan')
            ->add('day26Real')
            ->add('day27Plan')
            ->add('day27Real')
            ->add('day28Plan')
            ->add('day28Real')
            ->add('day29Plan')
            ->add('day29Real')
            ->add('day30Plan')
            ->add('day30Real')
            ->add('day31Plan')
            ->add('day31Real')
            ->add('enabled')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ->add('consumerPlanningService')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\Service\DetailConsumerPlanningService'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_seipbundle_dataload_service_detailconsumerplanningservice';
    }
}
