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
use Pequiven\MasterBundle\Entity\Personal;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Description of PersonalFixture
 *
 * @author matias
 */
class PersonalFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){

        $personal = new Personal();
        $personal->setCedula('18076543');
        $personal->setNomPersonal('SANCHEZ L, TANY C.');
        $personal->setNumPersonal('10022282');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-01'));
        $this->addReference('Personal-10022282', $personal);
            $manager->persist($personal);
            
        $personal = new Personal();
        $personal->setCedula('7013169');
        $personal->setNomPersonal('OLIVO Z , GEORGINA');
        $personal->setNumPersonal('10019081');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2158'));
        $this->addReference('Personal-18076543',$personal);
            $manager->persist($personal);
            
        $personal = new Personal();
        $personal->setCedula('9688155');
        $personal->setNomPersonal('ESCALONA O , VICTOR J');
        $personal->setNumPersonal('10016012');
        $personal->setEnabled(true);
        $personal->setCargo($this->getReference('Cargo-2038'));
        $this->addReference('Personal-9688155',$personal);
            $manager->persist($personal);
          
        $manager->flush();
    }
    
    public function getOrder(){
        return 4;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}