<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pequiven\SEIPBundle\Entity\Cargo;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Description of CargoFixture
 *
 * @author matias
 */
class CargoFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){
        
        $cargo = new Cargo();
        $cargo->setDescription('Abogado');
        $cargo->setEnabled(true);
        $cargo->setFkGerencia($this->getReference('Gerencia-01'));
            $manager->persist($cargo);
        
        $cargo = new Cargo();
        $cargo->setDescription('Analista de Sistemas');
        $cargo->setEnabled(true);
        $cargo->setFkGerencia($this->getReference('Gerencia-01'));
            $manager->persist($cargo);
            
        $manager->flush();
    }
    
    public function getOrder(){
        return 3;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
