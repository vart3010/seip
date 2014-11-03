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
use Pequiven\MasterBundle\Entity\Complejo;
use Pequiven\MasterBundle\Entity\Direction;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
/**
 * Description of DirectionFixture
 *
 * @author matias
 */
class DirectionFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){
        $complejo_data = new Complejo();
        $complejoNameArray = $complejo_data->getRefNameArray();
        
        $direction_data = new Direction();
        $directionNameArray = $direction_data->getRefNameArray();
        
        $direction = new Direction();
        $direction->setDescription('Dirección Ejecutiva de Recursos Humanos');
        $direction->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $this->addReference($directionNameArray[Direction::DIRECTION_RRHH], $direction);
            $manager->persist($direction);

        $direction = new Direction();
        $direction->setDescription('Dirección Ejecutiva de Proyectos');
        $direction->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $this->addReference($directionNameArray[Direction::DIRECTION_PROYECTOS], $direction);
            $manager->persist($direction);
        
        $manager->flush();
    }
    
    public function getOrder(){
        return 2;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
