<?php
namespace Pequiven\SEIPBundle\DataFixtures;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pequiven\SEIPBundle\Entity\Gerencia;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
/**
 * Description of ComplejoFixture
 *
 * @author matias
 */
class GerenciaFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.de Producción');
        $gerencia->setEnabled(true);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-01', $gerencia);
            $manager->persist($gerencia);
        
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.de Producción');
        $gerencia->setEnabled(true);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-02', $gerencia);
            $manager->persist($gerencia);
            
        $manager->flush();
    }
    
    public function getOrder(){
        return 2;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
