<?php
namespace Pequiven\MasterBundle\DataFixtures\ORM;
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
        $complejo_data = new Complejo();
        $complejoNameArray = $complejo_data->getRefNameArray();
        
        $complejo = new Complejo();
        $complejo->setDescription('Complejo Petroquímico Morón');
        $complejo->setRef($complejoNameArray[Complejo::COMPLEJO_CPMORON]);
        $complejo->setEnabled(true);
        $this->addReference($complejoNameArray[Complejo::COMPLEJO_CPMORON],$complejo);
            $manager->persist($complejo);

        $complejo = new Complejo();
        $complejo->setDescription('Complejo Petroquímico Ana Maria Campos');
        $complejo->setRef($complejoNameArray[Complejo::COMPLEJO_CPAMC]);
        $complejo->setEnabled(true);
        $this->addReference($complejoNameArray[Complejo::COMPLEJO_CPAMC],$complejo);
            $manager->persist($complejo);

        $complejo = new Complejo();
        $complejo->setDescription('Complejo Petroquímico GD José Antonio Anzoátegui');
        $complejo->setRef($complejoNameArray[Complejo::COMPLEJO_CPJAA]);
        $complejo->setEnabled(true);
        $this->addReference($complejoNameArray[Complejo::COMPLEJO_CPJAA],$complejo);
            $manager->persist($complejo);

        $complejo = new Complejo();
        $complejo->setDescription('Proyecto Navay');
        $complejo->setRef($complejoNameArray[Complejo::COMPLEJO_PRONAVAY]);
        $complejo->setEnabled(true);
        $this->addReference($complejoNameArray[Complejo::COMPLEJO_PRONAVAY],$complejo);
            $manager->persist($complejo);

//        $complejo = new Complejo();
//        $complejo->setDescription('Proyecto Paraguaná');
//        $complejo->setRef($complejoNameArray[Complejo::COMPLEJO_PROPARAGUANA]);
//        $complejo->setEnabled(true);
//        $this->addReference($complejoNameArray[Complejo::COMPLEJO_PROPARAGUANA],$complejo);
//            $manager->persist($complejo);

        $complejo = new Complejo();
        $complejo->setDescription('Sede Corporativa');
        $complejo->setRef($complejoNameArray[Complejo::COMPLEJO_ZIV]);
        $complejo->setEnabled(true);
        $this->addReference($complejoNameArray[Complejo::COMPLEJO_ZIV],$complejo);
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