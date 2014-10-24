<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\IndicatorBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pequiven\IndicatorBundle\Entity\IndicatorLevel;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
/**
 * Description of IndicatorLevelFixture
 *
 * @author matias
 */
class IndicatorLevelFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    
    protected $container;
    public function load(ObjectManager $manager){
            
        $indicatorLevel = new IndicatorLevel();
        $indicatorLevel->setDescription('Indicador Estratégico');
        $indicatorLevel->setLevel(IndicatorLevel::LEVEL_ESTRATEGICO);
        $indicatorLevel->setLevelName($indicatorLevel->level_name[IndicatorLevel::LEVEL_ESTRATEGICO]);
        $indicatorLevel->setEnabled(true);
        $this->addReference($indicatorLevel->level_name[IndicatorLevel::LEVEL_ESTRATEGICO], $indicatorLevel);
            $manager->persist($indicatorLevel);
        
        $indicatorLevel = new IndicatorLevel();
        $indicatorLevel->setDescription('Indicador Táctico');
        $indicatorLevel->setLevel(IndicatorLevel::LEVEL_TACTICO);
        $indicatorLevel->setLevelName($indicatorLevel->level_name[IndicatorLevel::LEVEL_TACTICO]);
        $indicatorLevel->setEnabled(true);
        $this->addReference($indicatorLevel->level_name[IndicatorLevel::LEVEL_TACTICO], $indicatorLevel);
            $manager->persist($indicatorLevel);
        
        $indicatorLevel = new IndicatorLevel();
        $indicatorLevel->setDescription('Indicador Operativo');
        $indicatorLevel->setLevel(IndicatorLevel::LEVEL_OPERATIVO);
        $indicatorLevel->setLevelName($indicatorLevel->level_name[IndicatorLevel::LEVEL_OPERATIVO]);
        $indicatorLevel->setEnabled(true);
        $this->addReference($indicatorLevel->level_name[IndicatorLevel::LEVEL_OPERATIVO], $indicatorLevel);
            $manager->persist($indicatorLevel);
          
        $manager->flush();
    }
    
    public function getOrder(){
        return 9;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
