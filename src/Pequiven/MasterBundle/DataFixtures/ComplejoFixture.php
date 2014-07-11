<?php
namespace Pequiven\MasterBundle\DataFixtures;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pequiven\MasterBundle\Entity\Complejo;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
/**
 * Description of ComplejoFixture
 *
 * @author matias
 */
class ComplejoFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){
        $complejo = new Complejo();
        $complejo->setDescription('Complejo Petroquímico Moron');
        $complejo->setEnabled(true);
        $this->addReference('Complejo-01',$complejo);
            $manager->persist($complejo);

        $complejo = new Complejo();
        $complejo->setDescription('Complejo Petroquímico Ana Maria Campos');
        $complejo->setEnabled(true);
        $this->addReference('Complejo-02',$complejo);
            $manager->persist($complejo);

        $complejo = new Complejo();
        $complejo->setDescription(' Complejo Petroquímico GD Jose Antonio Anzoátegui ');
        $complejo->setEnabled(true);
        $this->addReference('Complejo-03',$complejo);
            $manager->persist($complejo);

        $complejo = new Complejo();
        $complejo->setDescription(' Proyecto Navay');
        $complejo->setEnabled(true);
        $this->addReference('Complejo-04',$complejo);
            $manager->persist($complejo);

        $complejo = new Complejo();
        $complejo->setDescription(' Proyecto Paraguaná');
        $complejo->setEnabled(true);
        $this->addReference('Complejo-05',$complejo);
            $manager->persist($complejo);

        $complejo = new Complejo();
        $complejo->setDescription(' Sede Valencia');
        $complejo->setEnabled(true);
        $this->addReference('Complejo-06',$complejo);
            $manager->persist($complejo);
            
        $manager->flush();
    }
    
    public function getOrder(){
        return 1;
        
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}