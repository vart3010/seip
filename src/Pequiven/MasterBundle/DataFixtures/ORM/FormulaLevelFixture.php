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
use Pequiven\MasterBundle\Entity\FormulaLevel;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
/**
 * Description of FormulaLevelFixture
 *
 * @author matias
 */
class FormulaLevelFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    
    protected $container;
    public function load(ObjectManager $manager){
            
        $formulaLevel = new FormulaLevel();
        $formulaLevel->setDescription('Fórmula Estratégico');
        $formulaLevel->setLevel(FormulaLevel::LEVEL_ESTRATEGICO);
        $formulaLevel->setLevelName($formulaLevel->level_name[FormulaLevel::LEVEL_ESTRATEGICO]);
        $formulaLevel->setEnabled(true);
        $this->addReference($formulaLevel->level_name[FormulaLevel::LEVEL_ESTRATEGICO], $formulaLevel);
            $manager->persist($formulaLevel);
        
        $formulaLevel = new FormulaLevel();
        $formulaLevel->setDescription('Fórmula Táctico');
        $formulaLevel->setLevel(FormulaLevel::LEVEL_TACTICO);
        $formulaLevel->setLevelName($formulaLevel->level_name[FormulaLevel::LEVEL_TACTICO]);
        $formulaLevel->setEnabled(true);
        $this->addReference($formulaLevel->level_name[FormulaLevel::LEVEL_TACTICO], $formulaLevel);
            $manager->persist($formulaLevel);
        
        $formulaLevel = new FormulaLevel();
        $formulaLevel->setDescription('Fórmula Operativo');
        $formulaLevel->setLevel(FormulaLevel::LEVEL_OPERATIVO);
        $formulaLevel->setLevelName($formulaLevel->level_name[FormulaLevel::LEVEL_OPERATIVO]);
        $formulaLevel->setEnabled(true);
        $this->addReference($formulaLevel->level_name[FormulaLevel::LEVEL_OPERATIVO], $formulaLevel);
            $manager->persist($formulaLevel);
          
        $manager->flush();
    }
    
    public function getOrder(){
        return 11;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
