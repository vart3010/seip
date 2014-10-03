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
use Pequiven\MasterBundle\Entity\Tendency;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
/**
 * Description of TendencyFixture
 *
 * @author matias
 */
class TendencyFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){
        
        $objectTendency = new Tendency();
        $tendencyName = $objectTendency->getTendencyNameArray();
        
        //Favorable
        $tendency = new Tendency();
        $tendency->setDescription($tendencyName[Tendency::TENDENCY_MAX]);
        $tendency->setRef(Tendency::TENDENCY_MAX);
        $tendency->setEnabled(true);
            $manager->persist($tendency);
        
        //Desfavorable
        $tendency = new Tendency();
        $tendency->setDescription($tendencyName[Tendency::TENDENCY_MIN]);
        $tendency->setRef(Tendency::TENDENCY_MIN);
        $tendency->setEnabled(true);
            $manager->persist($tendency);

        //Estable
        $tendency = new Tendency();
        $tendency->setDescription($tendencyName[Tendency::TENDENCY_EST]);
        $tendency->setRef(Tendency::TENDENCY_EST);
        $tendency->setEnabled(true);
            $manager->persist($tendency);

        $manager->flush();
    }
    
    public function getOrder(){
        return 18;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
