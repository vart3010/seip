<?php

namespace Pequiven\MasterBundle\DataFixtures\ORM;

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
    protected $container;
    public function load(ObjectManager $manager){
        
        $objectArrangementRangeType = new ArrangementRangeType();
        $arrangementRangeTypeName = $objectArrangementRangeType->getRangeTypeNameArray();

        //Rango Alto Básico
        $arrangementRangeType = new ArrangementRangeType();
        $arrangementRangeType->setDescription($arrangementRangeTypeName[ArrangementRangeType::RANGE_TYPE_TOP_BASIC]);
        $arrangementRangeType->setRef($arrangementRangeTypeName[ArrangementRangeType::RANGE_TYPE_TOP_BASIC]);
        $arrangementRangeType->setEnabled(true);
            $manager->persist($arrangementRangeType);
            
        //Rango Medio Alto Básico
        $arrangementRangeType = new ArrangementRangeType();
        $arrangementRangeType->setDescription($arrangementRangeTypeName[ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_BASIC]);
        $arrangementRangeType->setRef($arrangementRangeTypeName[ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_BASIC]);
        $arrangementRangeType->setEnabled(true);
            $manager->persist($arrangementRangeType);
            
        //Rango Medio Bajo Básico
        $arrangementRangeType = new ArrangementRangeType();
        $arrangementRangeType->setDescription($arrangementRangeTypeName[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_BASIC]);
        $arrangementRangeType->setRef($arrangementRangeTypeName[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_BASIC]);
        $arrangementRangeType->setEnabled(true);
            $manager->persist($arrangementRangeType);

        //Rango Bajo Básico
        $arrangementRangeType = new ArrangementRangeType();
        $arrangementRangeType->setDescription($arrangementRangeTypeName[ArrangementRangeType::RANGE_TYPE_BOTTOM_BASIC]);
        $arrangementRangeType->setRef($arrangementRangeTypeName[ArrangementRangeType::RANGE_TYPE_BOTTOM_BASIC]);
        $arrangementRangeType->setEnabled(true);
            $manager->persist($arrangementRangeType);
            
        //Rango Alto Mixto
        $arrangementRangeType = new ArrangementRangeType();
        $arrangementRangeType->setDescription($arrangementRangeTypeName[ArrangementRangeType::RANGE_TYPE_TOP_MIXED]);
        $arrangementRangeType->setRef($arrangementRangeTypeName[ArrangementRangeType::RANGE_TYPE_TOP_MIXED]);
        $arrangementRangeType->setEnabled(true);
            $manager->persist($arrangementRangeType);
            
        //Rango Medio Alto Mixto
        $arrangementRangeType = new ArrangementRangeType();
        $arrangementRangeType->setDescription($arrangementRangeTypeName[ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_MIXED]);
        $arrangementRangeType->setRef($arrangementRangeTypeName[ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_MIXED]);
        $arrangementRangeType->setEnabled(true);
            $manager->persist($arrangementRangeType);
            
        //Rango Medio Bajo Mixto
        $arrangementRangeType = new ArrangementRangeType();
        $arrangementRangeType->setDescription($arrangementRangeTypeName[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_MIXED]);
        $arrangementRangeType->setRef($arrangementRangeTypeName[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_MIXED]);
        $arrangementRangeType->setEnabled(true);
            $manager->persist($arrangementRangeType);

        //Rango Bajo Mixto
        $arrangementRangeType = new ArrangementRangeType();
        $arrangementRangeType->setDescription($arrangementRangeTypeName[ArrangementRangeType::RANGE_TYPE_BOTTOM_MIXED]);
        $arrangementRangeType->setRef($arrangementRangeTypeName[ArrangementRangeType::RANGE_TYPE_BOTTOM_MIXED]);
        $arrangementRangeType->setEnabled(true);
            $manager->persist($arrangementRangeType);
            
        $manager->flush();
    }
    
    public function getOrder(){
        return 17;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
