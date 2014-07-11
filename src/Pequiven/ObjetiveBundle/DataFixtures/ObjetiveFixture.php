<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\ObjetiveBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pequiven\ObjetiveBundle\Entity\Objetive;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
/**
 * Description of ObjetiveLevelFixture
 *
 * @author matias
 */
class ObjetiveFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){
        
//        $objetive = new Objetive();
//        $objetive->setDescription('Alinear.....');
//        $objetive->setEnabled(true);
//        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
//        $this->addReference('1', $objetive);
//            $manager->persist($objetive);
//            
//        $objetive = new Objetive();
//        $objetive->setDescription('Alinear.....1.2');
//        $objetive->setEnabled(true);
//        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_TACTICO'));
//        $this->addReference('1.1', $objetive);
//        $objetive->setParent($this->getReference('1'));
//            $manager->persist($objetive);
          
        $manager->flush();
    }
    
    public function getOrder(){
        return 8;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
