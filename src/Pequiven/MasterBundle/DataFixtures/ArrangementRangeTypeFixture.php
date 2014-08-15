<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pequiven\MasterBundle\Entity\ArrangementRangeType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
/**
 * Description of ArrangementRangeTypeFixture
 *
 * @author matias
 */
class ArrangementRangeTypeFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){
        
        $objectArrangementRangeType = new ArrangementRangeType();
        $arrangementRangeTypeName = $objectArrangementRangeType->getRangeTypeNameArray();

        //Rango Alto Básico
        $arrangementRangeType = new ArrangementRangeType();
        $arrangementRangeType->setDescription($arrangementRangeTypeName[ArrangementRangeType::RANGE_TYPE_TOP_BASIC]);
        $arrangementRangeType->setRef('Alto');
        $arrangementRangeType->setEnabled(true);
            $manager->persist($arrangementRangeType);
            
        //Rango Medio Básico
        $arrangementRangeType = new ArrangementRangeType();
        $arrangementRangeType->setDescription($arrangementRangeTypeName[ArrangementRangeType::RANGE_TYPE_MIDDLE_BASIC]);
        $arrangementRangeType->setRef('Medio');
        $arrangementRangeType->setEnabled(true);
            $manager->persist($arrangementRangeType);

        //Rango Bajo Básico
        $arrangementRangeType = new ArrangementRangeType();
        $arrangementRangeType->setDescription($arrangementRangeTypeName[ArrangementRangeType::RANGE_TYPE_BOTTOM_BASIC]);
        $arrangementRangeType->setRef('Bajo');
        $arrangementRangeType->setEnabled(true);
            $manager->persist($arrangementRangeType);

        //Rango Alto Compuesto
        $arrangementRangeType = new ArrangementRangeType();
        $arrangementRangeType->setDescription($arrangementRangeTypeName[ArrangementRangeType::RANGE_TYPE_TOP_COMPOUND]);
        $arrangementRangeType->setRef('Alto-Alto|Alto-Bajo');
        $arrangementRangeType->setEnabled(true);
            $manager->persist($arrangementRangeType);

        //Rango Medio Compuesto
        $arrangementRangeType = new ArrangementRangeType();
        $arrangementRangeType->setDescription($arrangementRangeTypeName[ArrangementRangeType::RANGE_TYPE_MIDDLE_COMPOUND]);
        $arrangementRangeType->setRef('Medio-Alto|Medio-Bajo');
        $arrangementRangeType->setEnabled(true);
            $manager->persist($arrangementRangeType);
            
        //Rango Bajo Compuesto
        $arrangementRangeType = new ArrangementRangeType();
        $arrangementRangeType->setDescription($arrangementRangeTypeName[ArrangementRangeType::RANGE_TYPE_BOTTOM_COMPOUND]);
        $arrangementRangeType->setRef('Bajo-Alto|Bajo-Bajo');
        $arrangementRangeType->setEnabled(true);
            $manager->persist($arrangementRangeType);
            
        $manager->flush();
    }
    
    public function getOrder(){
        return 15;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }            
}
