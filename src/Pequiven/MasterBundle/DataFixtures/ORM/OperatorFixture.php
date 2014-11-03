<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pequiven\MasterBundle\Entity\Operator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
/**
 * Description of OperatorFixture
 *
 * @author matias
 */
class OperatorFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){
        
        $objectOperator = new Operator();
        $operatorName = $objectOperator->getOperatorNameArray();
        
        //Mayor Que
        $operator = new Operator();
        $operator->setDescription($operatorName[Operator::OPERATOR_HIGHER_THAN]);
        $operator->setRef('>');
        $operator->setEnabled(true);
            $manager->persist($operator);
            
        //Menor Que
        $operator = new Operator();
        $operator->setDescription($operatorName[Operator::OPERATOR_SMALLER_THAN]);
        $operator->setRef('<');
        $operator->setEnabled(true);
            $manager->persist($operator);
            
        //Mayor o Igual Que
        $operator = new Operator();
        $operator->setDescription($operatorName[Operator::OPERATOR_HIGHER_EQUAL_THAN]);
        $operator->setRef('>=');
        $operator->setEnabled(true);
            $manager->persist($operator);
            
        //Menor o Igual Que
        $operator = new Operator();
        $operator->setDescription($operatorName[Operator::OPERATOR_SMALLER_EQUAL_THAN]);
        $operator->setRef('<=');
        $operator->setEnabled(true);
            $manager->persist($operator);
            
        //Igual A
        $operator = new Operator();
        $operator->setDescription($operatorName[Operator::OPERATOR_EQUAL]);
        $operator->setRef('=');
        $operator->setEnabled(true);
            $manager->persist($operator);
            
        $manager->flush();
    }
    
    public function getOrder(){
        return 16;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
