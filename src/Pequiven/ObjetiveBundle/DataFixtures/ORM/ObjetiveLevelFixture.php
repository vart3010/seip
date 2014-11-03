<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\ObjetiveBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
/**
 * Description of ObjetiveLevelFixture
 *
 * @author matias
 */
class ObjetiveLevelFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){
        
        
        $objetiveLevel = new ObjetiveLevel();
        $objetiveLevel->setDescription('Objetivo Estratégico');
        $objetiveLevel->setLevel(ObjetiveLevel::LEVEL_ESTRATEGICO);
        $objetiveLevel->setLevelName($objetiveLevel->level_name[ObjetiveLevel::LEVEL_ESTRATEGICO]);
        $objetiveLevel->setEnabled(true);
        $this->addReference($objetiveLevel->level_name[ObjetiveLevel::LEVEL_ESTRATEGICO], $objetiveLevel);
            $manager->persist($objetiveLevel);
        
        $objetiveLevel = new ObjetiveLevel();
        $objetiveLevel->setDescription('Objetivo Táctico');
        $objetiveLevel->setLevel(ObjetiveLevel::LEVEL_TACTICO);
        $objetiveLevel->setLevelName($objetiveLevel->level_name[ObjetiveLevel::LEVEL_TACTICO]);
        $objetiveLevel->setEnabled(true);
        $this->addReference($objetiveLevel->level_name[ObjetiveLevel::LEVEL_TACTICO], $objetiveLevel);
            $manager->persist($objetiveLevel);
        
        $objetiveLevel = new ObjetiveLevel();
        $objetiveLevel->setDescription('Objetivo Operativo');
        $objetiveLevel->setLevel(ObjetiveLevel::LEVEL_OPERATIVO);
        $objetiveLevel->setLevelName($objetiveLevel->level_name[ObjetiveLevel::LEVEL_OPERATIVO]);
        $objetiveLevel->setEnabled(true);
        $this->addReference($objetiveLevel->level_name[ObjetiveLevel::LEVEL_OPERATIVO], $objetiveLevel);
            $manager->persist($objetiveLevel);
          
        $manager->flush();
    }
    
    public function getOrder(){
        return 8;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
