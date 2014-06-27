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
 * DataFixture de los Cargos
 *
 * @author matias
 */
class CargoFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){
        
        //  CARGOS COMPLEJO PETROQUIMICO MORON

$cargo= new Cargo();
$cargo->setDescription('Abogado');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-01'));
$this->addReference('Cargo-01',$cargo);
  $manager->persist($cargo);

$cargo= new Cargo();
$cargo->setDescription('Abogado Empresa RGARMO C.A.');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-01'));
$this->addReference('Cargo-02',$cargo);
  $manager->persist($cargo);

$cargo= new Cargo();
$cargo->setDescription('Abogado Proyecto Paraguaná');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-01'));
$this->addReference('Cargo-03',$cargo);
  $manager->persist($cargo);

$cargo= new Cargo();
$cargo->setDescription('Administración Contratos');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-19'));
$this->addReference('Cargo-04',$cargo);
  $manager->persist($cargo);

$cargo= new Cargo();
$cargo->setDescription('Administrador de Contratos');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-19'));
$this->addReference('Cargo-05',$cargo);
  $manager->persist($cargo);

$cargo= new Cargo();
$cargo->setDescription('Administrador de Contratos de Gases');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-21'));
$this->addReference('Cargo-06',$cargo);
  $manager->persist($cargo);

$cargo= new Cargo();
$cargo->setDescription('Administrador de Proyectos');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-03'));
$this->addReference('Cargo-07',$cargo);
  $manager->persist($cargo);

$cargo= new Cargo();
$cargo->setDescription('Administrador de Salud');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-11'));
$this->addReference('Cargo-08',$cargo);
  $manager->persist($cargo);

$cargo= new Cargo();
$cargo->setDescription('Administrador del SISDEM');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-04'));
$this->addReference('Cargo-09',$cargo);
  $manager->persist($cargo);

$cargo= new Cargo();
$cargo->setDescription('Administrador Gerencias');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-10'));
$this->addReference('Cargo-10',$cargo);
  $manager->persist($cargo);

$cargo= new Cargo();
$cargo->setDescription('Administrador y Ctrol.de Estudios');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-04'));
$this->addReference('Cargo-11',$cargo);
  $manager->persist($cargo);

$cargo= new Cargo();
$cargo->setDescription('Albañil');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-17'));
$this->addReference('Cargo-12',$cargo);
  $manager->persist($cargo);

$cargo= new Cargo();
$cargo->setDescription('Albañil de 2da');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-17'));
$this->addReference('Cargo-13',$cargo);
  $manager->persist($cargo);

$cargo= new Cargo();
$cargo->setDescription('Almacenista ');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-20'));
$this->addReference('Cargo-14',$cargo);
  $manager->persist($cargo);

$cargo= new Cargo();
$cargo->setDescription('Almacenista ');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-15'));
$this->addReference('Cargo-15',$cargo);
  $manager->persist($cargo);

$cargo= new Cargo();
$cargo->setDescription('An.Administración de Mantenimiento');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-14'));
$this->addReference('Cargo-16',$cargo);
  $manager->persist($cargo);

$cargo= new Cargo();
$cargo->setDescription('An.de Academico');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-04'));
$this->addReference('Cargo-17',$cargo);
  $manager->persist($cargo);

$cargo= new Cargo();
$cargo->setDescription('An.de Despacho Prod.Aromáticos');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-21'));
$this->addReference('Cargo-18',$cargo);
  $manager->persist($cargo);

$cargo= new Cargo();
$cargo->setDescription('An.de Formación Continua');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-04'));
$this->addReference('Cargo-19',$cargo);
  $manager->persist($cargo);

$cargo= new Cargo();
$cargo->setDescription('An.de Gestión y Control');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-21'));
$this->addReference('Cargo-20',$cargo);
  $manager->persist($cargo);

$cargo= new Cargo();
$cargo->setDescription('An.de Logística y Servicios');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-04'));
$this->addReference('Cargo-21',$cargo);
  $manager->persist($cargo);

$cargo= new Cargo();
$cargo->setDescription('An.de Planificación Operativa');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-21'));
$this->addReference('Cargo-22',$cargo);
  $manager->persist($cargo);

$cargo= new Cargo();
$cargo->setDescription('An.de Planificación Operativa');
$cargo->setEnabled(1);
$cargo->setGerencia($this->getReference('Gerencia-20'));
$this->addReference('Cargo-23',$cargo);
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
