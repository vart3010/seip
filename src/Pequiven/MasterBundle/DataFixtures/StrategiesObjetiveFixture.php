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
use Pequiven\MasterBundle\Entity\StrategiesObjetive;
use Pequiven\ObjetiveBundle\Entity\Objetive;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;


/**
 * Description of StrategiesObjetiveFixture
 *
 * @author matias
 */
class StrategiesObjetiveFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    //put your code here
    
    protected $container;
    public function load(ObjectManager $manager){
        
        //1.1.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar el cumplimiento de los procedimientos '
                . 'operacionales y administrativos, orientados a la certificación y mejora en '
                . 'la calidad de nuestros productos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-01-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-01-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar el cumplimiento de los procedimientos '
                . 'operacionales y administrativos, orientados a la certificación y mejora en '
                . 'la calidad de nuestros productos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-02-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-02-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar el cumplimiento de los procedimientos '
                . 'operacionales y administrativos, orientados a la certificación y mejora en '
                . 'la calidad de nuestros productos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-03-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-03-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar el cumplimiento de los procedimientos '
                . 'operacionales y administrativos, orientados a la certificación y mejora en '
                . 'la calidad de nuestros productos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-04-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-04-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar el cumplimiento de los procedimientos '
                . 'operacionales y administrativos, orientados a la certificación y mejora en '
                . 'la calidad de nuestros productos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-05-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-05-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar el cumplimiento de los procedimientos '
                . 'operacionales y administrativos, orientados a la certificación y mejora en '
                . 'la calidad de nuestros productos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-06-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-06-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //1.1.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar acciones que permitan alcanzar una '
                . 'producción acorde con la capacidad de diseño de las instalaciones existentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-01-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-07-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar acciones que permitan alcanzar una '
                . 'producción acorde con la capacidad de diseño de las instalaciones existentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-02-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-08-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar acciones que permitan alcanzar una '
                . 'producción acorde con la capacidad de diseño de las instalaciones existentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-03-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-09-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar acciones que permitan alcanzar una '
                . 'producción acorde con la capacidad de diseño de las instalaciones existentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-04-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-10-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar acciones que permitan alcanzar una '
                . 'producción acorde con la capacidad de diseño de las instalaciones existentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-05-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-11-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar acciones que permitan alcanzar una '
                . 'producción acorde con la capacidad de diseño de las instalaciones existentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-06-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-12-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //1.1.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar planes de mantenimiento de las '
                . 'instalaciones orientados hacia la filosofía de mantenimiento centrado '
                . 'en la confiabilidad.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-01-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-13-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar planes de mantenimiento de las '
                . 'instalaciones orientados hacia la filosofía de mantenimiento centrado '
                . 'en la confiabilidad.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-02-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-14-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar planes de mantenimiento de las '
                . 'instalaciones orientados hacia la filosofía de mantenimiento centrado '
                . 'en la confiabilidad.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-03-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-15-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar planes de mantenimiento de las '
                . 'instalaciones orientados hacia la filosofía de mantenimiento centrado '
                . 'en la confiabilidad.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-04-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-16-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar planes de mantenimiento de las '
                . 'instalaciones orientados hacia la filosofía de mantenimiento centrado '
                . 'en la confiabilidad.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-05-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-17-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar planes de mantenimiento de las '
                . 'instalaciones orientados hacia la filosofía de mantenimiento centrado '
                . 'en la confiabilidad.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-06-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-18-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //1.1.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Gestionar el suministro continuo, suficiente, '
                . 'oportuno y de calidad de las materias primas y servicios industriales; '
                . 'así como su uso eficiente en nuestras instalaciones');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-01-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-19-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Gestionar el suministro continuo, suficiente, '
                . 'oportuno y de calidad de las materias primas y servicios industriales; '
                . 'así como su uso eficiente en nuestras instalaciones');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-02-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-20-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Gestionar el suministro continuo, suficiente, '
                . 'oportuno y de calidad de las materias primas y servicios industriales; '
                . 'así como su uso eficiente en nuestras instalaciones');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-03-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-21-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Gestionar el suministro continuo, suficiente, '
                . 'oportuno y de calidad de las materias primas y servicios industriales; '
                . 'así como su uso eficiente en nuestras instalaciones');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-04-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-22-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Gestionar el suministro continuo, suficiente, '
                . 'oportuno y de calidad de las materias primas y servicios industriales; '
                . 'así como su uso eficiente en nuestras instalaciones');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-05-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-23-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Gestionar el suministro continuo, suficiente, '
                . 'oportuno y de calidad de las materias primas y servicios industriales; '
                . 'así como su uso eficiente en nuestras instalaciones');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-06-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-24-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //1.1.5
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar planes de adecuación tecnológica en '
                . 'las instalaciones existentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-01-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-25-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar planes de adecuación tecnológica en '
                . 'las instalaciones existentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-02-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-26-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar planes de adecuación tecnológica en '
                . 'las instalaciones existentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-03-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-27-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar planes de adecuación tecnológica en '
                . 'las instalaciones existentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-04-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-28-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar planes de adecuación tecnológica en '
                . 'las instalaciones existentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-05-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-29-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar planes de adecuación tecnológica en '
                . 'las instalaciones existentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-06-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-30-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //1.1.6
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar procesos de procura que garanticen '
                . 'la disponibilidad de repuestos, materiales e insumos requeridos para las '
                . 'operaciones.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-01-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-31-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar procesos de procura que garanticen '
                . 'la disponibilidad de repuestos, materiales e insumos requeridos para las '
                . 'operaciones.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-02-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-32-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar procesos de procura que garanticen '
                . 'la disponibilidad de repuestos, materiales e insumos requeridos para las '
                . 'operaciones.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-03-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-33-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar procesos de procura que garanticen '
                . 'la disponibilidad de repuestos, materiales e insumos requeridos para las '
                . 'operaciones.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-04-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-34-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar procesos de procura que garanticen '
                . 'la disponibilidad de repuestos, materiales e insumos requeridos para las '
                . 'operaciones.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-05-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-35-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar procesos de procura que garanticen '
                . 'la disponibilidad de repuestos, materiales e insumos requeridos para las '
                . 'operaciones.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-06-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-36-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //1.2.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar un Sistema de Gestión Estratégica con '
                . 'base en los Macroprocesos Medulares de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-07-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-37-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar un Sistema de Gestión Estratégica con '
                . 'base en los Macroprocesos Medulares de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-08-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-38-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar un Sistema de Gestión Estratégica con '
                . 'base en los Macroprocesos Medulares de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-09-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-39-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar un Sistema de Gestión Estratégica con '
                . 'base en los Macroprocesos Medulares de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-10-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-40-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar un Sistema de Gestión Estratégica con '
                . 'base en los Macroprocesos Medulares de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-11-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-41-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar un Sistema de Gestión Estratégica con '
                . 'base en los Macroprocesos Medulares de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-12-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-42-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //1.2.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Mantener las certificaciones y continuar con '
                . 'los planes de normalización de los procesos de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-07-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-43-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Mantener las certificaciones y continuar con '
                . 'los planes de normalización de los procesos de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-08-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-44-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Mantener las certificaciones y continuar con '
                . 'los planes de normalización de los procesos de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-09-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-45-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Mantener las certificaciones y continuar con '
                . 'los planes de normalización de los procesos de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-10-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-46-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Mantener las certificaciones y continuar con '
                . 'los planes de normalización de los procesos de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-11-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-47-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Mantener las certificaciones y continuar con '
                . 'los planes de normalización de los procesos de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-12-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-48-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //1.2.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos de mejores prácticas de la '
                . 'industria mediante el análisis de comparación con referentes nacionales '
                . 'e internacionales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-07-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-49-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos de mejores prácticas de la '
                . 'industria mediante el análisis de comparación con referentes nacionales '
                . 'e internacionales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-08-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-50-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos de mejores prácticas de la '
                . 'industria mediante el análisis de comparación con referentes nacionales '
                . 'e internacionales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-09-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-51-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos de mejores prácticas de la '
                . 'industria mediante el análisis de comparación con referentes nacionales '
                . 'e internacionales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-10-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-52-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos de mejores prácticas de la '
                . 'industria mediante el análisis de comparación con referentes nacionales '
                . 'e internacionales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-11-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-53-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos de mejores prácticas de la '
                . 'industria mediante el análisis de comparación con referentes nacionales '
                . 'e internacionales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-12-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-54-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.1.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar el control efectivo de la ejecución '
                . 'presupuestaria planificada bajo la normativa legal vigente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-13-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-55-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar el control efectivo de la ejecución '
                . 'presupuestaria planificada bajo la normativa legal vigente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-14-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-56-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar el control efectivo de la ejecución '
                . 'presupuestaria planificada bajo la normativa legal vigente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-15-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-57-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar el control efectivo de la ejecución '
                . 'presupuestaria planificada bajo la normativa legal vigente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-16-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-58-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar el control efectivo de la ejecución '
                . 'presupuestaria planificada bajo la normativa legal vigente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-17-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-59-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar el control efectivo de la ejecución '
                . 'presupuestaria planificada bajo la normativa legal vigente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-18-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-60-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.1.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar los procesos de contratación y control '
                . 'de la ejecución de obras, prestación de servicios y adquisición de bienes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-13-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-61-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar los procesos de contratación y control '
                . 'de la ejecución de obras, prestación de servicios y adquisición de bienes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-14-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-62-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar los procesos de contratación y control '
                . 'de la ejecución de obras, prestación de servicios y adquisición de bienes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-15-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-63-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar los procesos de contratación y control '
                . 'de la ejecución de obras, prestación de servicios y adquisición de bienes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-16-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-64-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar los procesos de contratación y control '
                . 'de la ejecución de obras, prestación de servicios y adquisición de bienes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-17-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-65-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar los procesos de contratación y control '
                . 'de la ejecución de obras, prestación de servicios y adquisición de bienes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-18-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-66-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.1.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar las políticas de créditos, cobranzas '
                . 'y pagos que permitan garantizar la liquidez de la empresa.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-13-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-67-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar las políticas de créditos, cobranzas '
                . 'y pagos que permitan garantizar la liquidez de la empresa.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-14-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-68-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar las políticas de créditos, cobranzas '
                . 'y pagos que permitan garantizar la liquidez de la empresa.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-15-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-69-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar las políticas de créditos, cobranzas '
                . 'y pagos que permitan garantizar la liquidez de la empresa.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-16-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-70-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar las políticas de créditos, cobranzas '
                . 'y pagos que permitan garantizar la liquidez de la empresa.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-17-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-71-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar las políticas de créditos, cobranzas '
                . 'y pagos que permitan garantizar la liquidez de la empresa.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-18-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-72-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.1.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Evaluar el flujo de caja y la disponibilidad de '
                . 'fondos con el fin de garantizar su correcta distribución y uso.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-13-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-73-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Evaluar el flujo de caja y la disponibilidad de '
                . 'fondos con el fin de garantizar su correcta distribución y uso.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-14-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-74-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Evaluar el flujo de caja y la disponibilidad de '
                . 'fondos con el fin de garantizar su correcta distribución y uso.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-15-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-75-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Evaluar el flujo de caja y la disponibilidad de '
                . 'fondos con el fin de garantizar su correcta distribución y uso.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-16-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-76-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Evaluar el flujo de caja y la disponibilidad de '
                . 'fondos con el fin de garantizar su correcta distribución y uso.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-17-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-77-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Evaluar el flujo de caja y la disponibilidad de '
                . 'fondos con el fin de garantizar su correcta distribución y uso.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-18-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-78-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.1.5
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar los niveles de inventario con el fin de '
                . 'mejorar el flujo de caja, reducir los costos y minimizar la carga fiscal '
                . 'de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-13-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-79-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar los niveles de inventario con el fin de '
                . 'mejorar el flujo de caja, reducir los costos y minimizar la carga fiscal '
                . 'de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-14-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-80-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar los niveles de inventario con el fin de '
                . 'mejorar el flujo de caja, reducir los costos y minimizar la carga fiscal '
                . 'de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-15-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-81-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar los niveles de inventario con el fin de '
                . 'mejorar el flujo de caja, reducir los costos y minimizar la carga fiscal '
                . 'de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-16-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-82-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar los niveles de inventario con el fin de '
                . 'mejorar el flujo de caja, reducir los costos y minimizar la carga fiscal '
                . 'de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-17-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-83-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar los niveles de inventario con el fin de '
                . 'mejorar el flujo de caja, reducir los costos y minimizar la carga fiscal '
                . 'de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-18-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-84-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.1.6
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Maximizar los beneficios de exención y exoneración '
                . 'de impuestos aplicables a la Corporación y filiales, dentro de los procesos '
                . 'productivos y comerciales de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-13-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-85-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Maximizar los beneficios de exención y exoneración '
                . 'de impuestos aplicables a la Corporación y filiales, dentro de los procesos '
                . 'productivos y comerciales de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-14-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-86-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Maximizar los beneficios de exención y exoneración '
                . 'de impuestos aplicables a la Corporación y filiales, dentro de los procesos '
                . 'productivos y comerciales de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-15-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-87-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Maximizar los beneficios de exención y exoneración '
                . 'de impuestos aplicables a la Corporación y filiales, dentro de los procesos '
                . 'productivos y comerciales de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-16-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-88-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Maximizar los beneficios de exención y exoneración '
                . 'de impuestos aplicables a la Corporación y filiales, dentro de los procesos '
                . 'productivos y comerciales de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-17-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-89-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Maximizar los beneficios de exención y exoneración '
                . 'de impuestos aplicables a la Corporación y filiales, dentro de los procesos '
                . 'productivos y comerciales de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-18-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-90-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.1.7
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer los procesos en materia de control previo,'
                . ' auditorias interna y externas, contabilidad y contraloría financiera y '
                . 'comunicación efectiva con todas las áreas que apoye a la toma de decisiones '
                . 'financiera de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-13-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-91-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer los procesos en materia de control previo,'
                . ' auditorias interna y externas, contabilidad y contraloría financiera y '
                . 'comunicación efectiva con todas las áreas que apoye a la toma de decisiones '
                . 'financiera de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-14-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-92-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer los procesos en materia de control previo,'
                . ' auditorias interna y externas, contabilidad y contraloría financiera y '
                . 'comunicación efectiva con todas las áreas que apoye a la toma de decisiones '
                . 'financiera de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-15-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-93-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer los procesos en materia de control previo,'
                . ' auditorias interna y externas, contabilidad y contraloría financiera y '
                . 'comunicación efectiva con todas las áreas que apoye a la toma de decisiones '
                . 'financiera de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-16-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-94-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer los procesos en materia de control previo,'
                . ' auditorias interna y externas, contabilidad y contraloría financiera y '
                . 'comunicación efectiva con todas las áreas que apoye a la toma de decisiones '
                . 'financiera de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-17-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-95-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer los procesos en materia de control previo,'
                . ' auditorias interna y externas, contabilidad y contraloría financiera y '
                . 'comunicación efectiva con todas las áreas que apoye a la toma de decisiones '
                . 'financiera de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-18-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-96-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.1.8
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Definir mecanismos para la obtención de '
                . 'financiamiento para los proyectos y sus respectivos desembolsos de forma '
                . 'oportuna.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-13-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-97-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Definir mecanismos para la obtención de '
                . 'financiamiento para los proyectos y sus respectivos desembolsos de forma '
                . 'oportuna.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-14-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-98-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Definir mecanismos para la obtención de '
                . 'financiamiento para los proyectos y sus respectivos desembolsos de forma '
                . 'oportuna.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-15-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-99-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Definir mecanismos para la obtención de '
                . 'financiamiento para los proyectos y sus respectivos desembolsos de forma '
                . 'oportuna.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-16-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-100-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Definir mecanismos para la obtención de '
                . 'financiamiento para los proyectos y sus respectivos desembolsos de forma '
                . 'oportuna.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-17-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-101-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Definir mecanismos para la obtención de '
                . 'financiamiento para los proyectos y sus respectivos desembolsos de forma '
                . 'oportuna.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-18-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-102-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.1.9
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar  la operatividad del Comité de Finanzas '
                . 'como órgano autónomo que apoye en las funciones de revisión, evaluación, '
                . 'validación y emisión de recomendaciones en operaciones de impacto financiero.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-13-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-103-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar  la operatividad del Comité de Finanzas '
                . 'como órgano autónomo que apoye en las funciones de revisión, evaluación, '
                . 'validación y emisión de recomendaciones en operaciones de impacto financiero.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-14-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-104-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar  la operatividad del Comité de Finanzas '
                . 'como órgano autónomo que apoye en las funciones de revisión, evaluación, '
                . 'validación y emisión de recomendaciones en operaciones de impacto financiero.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-15-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-105-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar  la operatividad del Comité de Finanzas '
                . 'como órgano autónomo que apoye en las funciones de revisión, evaluación, '
                . 'validación y emisión de recomendaciones en operaciones de impacto financiero.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-16-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-106-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar  la operatividad del Comité de Finanzas '
                . 'como órgano autónomo que apoye en las funciones de revisión, evaluación, '
                . 'validación y emisión de recomendaciones en operaciones de impacto financiero.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-17-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-107-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar  la operatividad del Comité de Finanzas '
                . 'como órgano autónomo que apoye en las funciones de revisión, evaluación, '
                . 'validación y emisión de recomendaciones en operaciones de impacto financiero.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-18-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-108-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.1.10
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos para la oportuna cancelación '
                . 'del subsidio a los precios de venta de los productos petroquímicos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-13-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-109-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos para la oportuna cancelación '
                . 'del subsidio a los precios de venta de los productos petroquímicos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-14-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-110-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
        
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos para la oportuna cancelación '
                . 'del subsidio a los precios de venta de los productos petroquímicos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-15-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-111-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos para la oportuna cancelación '
                . 'del subsidio a los precios de venta de los productos petroquímicos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-16-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-112-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos para la oportuna cancelación '
                . 'del subsidio a los precios de venta de los productos petroquímicos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-17-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-113-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos para la oportuna cancelación '
                . 'del subsidio a los precios de venta de los productos petroquímicos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-18-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-114-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.2.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar un sistema de actualización continua '
                . 'de las estructuras de costo de cada línea de producción.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-19-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-115-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar un sistema de actualización continua '
                . 'de las estructuras de costo de cada línea de producción.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-20-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-116-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar un sistema de actualización continua '
                . 'de las estructuras de costo de cada línea de producción.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-21-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-117-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar un sistema de actualización continua '
                . 'de las estructuras de costo de cada línea de producción.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-22-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-118-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar un sistema de actualización continua '
                . 'de las estructuras de costo de cada línea de producción.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-23-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-119-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar un sistema de actualización continua '
                . 'de las estructuras de costo de cada línea de producción.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-24-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-120-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.2.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar un sistema de planificación de costos '
                . 'para apalancar y fortalecer la gerencia estratégica de costos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-19-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-121-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar un sistema de planificación de costos '
                . 'para apalancar y fortalecer la gerencia estratégica de costos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-20-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-122-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar un sistema de planificación de costos '
                . 'para apalancar y fortalecer la gerencia estratégica de costos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-21-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-123-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar un sistema de planificación de costos '
                . 'para apalancar y fortalecer la gerencia estratégica de costos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-22-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-124-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar un sistema de planificación de costos '
                . 'para apalancar y fortalecer la gerencia estratégica de costos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-23-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-125-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar un sistema de planificación de costos '
                . 'para apalancar y fortalecer la gerencia estratégica de costos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-24-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-126-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.2.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos para generar alertas y '
                . 'corregir desviaciones relacionadas a gastos y costos directos y/o '
                . 'indirectos de los procesos de producción y compras.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-19-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-127-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos para generar alertas y '
                . 'corregir desviaciones relacionadas a gastos y costos directos y/o '
                . 'indirectos de los procesos de producción y compras.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-20-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-128-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos para generar alertas y '
                . 'corregir desviaciones relacionadas a gastos y costos directos y/o '
                . 'indirectos de los procesos de producción y compras.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-21-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-129-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos para generar alertas y '
                . 'corregir desviaciones relacionadas a gastos y costos directos y/o '
                . 'indirectos de los procesos de producción y compras.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-22-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-130-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos para generar alertas y '
                . 'corregir desviaciones relacionadas a gastos y costos directos y/o '
                . 'indirectos de los procesos de producción y compras.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-23-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-131-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos para generar alertas y '
                . 'corregir desviaciones relacionadas a gastos y costos directos y/o '
                . 'indirectos de los procesos de producción y compras.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-24-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-132-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.1.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover una política de precios que permitan '
                . 'garantizar la sostenibilidad de cada línea de negocios en el marco de la '
                . 'Ley Orgánica de Precios Justos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-25-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-133-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover una política de precios que permitan '
                . 'garantizar la sostenibilidad de cada línea de negocios en el marco de la '
                . 'Ley Orgánica de Precios Justos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-26-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-134-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover una política de precios que permitan '
                . 'garantizar la sostenibilidad de cada línea de negocios en el marco de la '
                . 'Ley Orgánica de Precios Justos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-27-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-135-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover una política de precios que permitan '
                . 'garantizar la sostenibilidad de cada línea de negocios en el marco de la '
                . 'Ley Orgánica de Precios Justos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-28-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-136-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover una política de precios que permitan '
                . 'garantizar la sostenibilidad de cada línea de negocios en el marco de la '
                . 'Ley Orgánica de Precios Justos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-29-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-137-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover una política de precios que permitan '
                . 'garantizar la sostenibilidad de cada línea de negocios en el marco de la '
                . 'Ley Orgánica de Precios Justos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-30-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-138-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.1.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer en los trabajadores la cultura de la'
                . ' calidad y el enfoque al cliente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-25-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-139-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer en los trabajadores la cultura de la'
                . ' calidad y el enfoque al cliente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-26-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-140-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer en los trabajadores la cultura de la'
                . ' calidad y el enfoque al cliente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-27-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-141-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer en los trabajadores la cultura de la'
                . ' calidad y el enfoque al cliente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-28-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-142-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer en los trabajadores la cultura de la'
                . ' calidad y el enfoque al cliente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-29-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-143-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer en los trabajadores la cultura de la'
                . ' calidad y el enfoque al cliente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-30-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-144-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.1.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar alianzas con proveedores que fortalezcan'
                . ' canales de distribución y mejore la atención del mercado.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-25-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-145-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar alianzas con proveedores que fortalezcan'
                . ' canales de distribución y mejore la atención del mercado.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-26-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-146-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar alianzas con proveedores que fortalezcan'
                . ' canales de distribución y mejore la atención del mercado.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-27-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-147-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar alianzas con proveedores que fortalezcan'
                . ' canales de distribución y mejore la atención del mercado.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-28-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-148-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar alianzas con proveedores que fortalezcan'
                . ' canales de distribución y mejore la atención del mercado.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-29-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-149-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar alianzas con proveedores que fortalezcan'
                . ' canales de distribución y mejore la atención del mercado.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-30-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-150-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.1.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Diseñar e implementar programas de promoción, '
                . 'servicio y asesoría técnico-comercial a clientes, que permitan el '
                . 'fortalecimiento de la imagen de nuestros productos y servicios.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-25-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-151-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Diseñar e implementar programas de promoción, '
                . 'servicio y asesoría técnico-comercial a clientes, que permitan el '
                . 'fortalecimiento de la imagen de nuestros productos y servicios.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-26-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-152-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Diseñar e implementar programas de promoción, '
                . 'servicio y asesoría técnico-comercial a clientes, que permitan el '
                . 'fortalecimiento de la imagen de nuestros productos y servicios.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-27-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-153-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Diseñar e implementar programas de promoción, '
                . 'servicio y asesoría técnico-comercial a clientes, que permitan el '
                . 'fortalecimiento de la imagen de nuestros productos y servicios.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-28-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-154-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Diseñar e implementar programas de promoción, '
                . 'servicio y asesoría técnico-comercial a clientes, que permitan el '
                . 'fortalecimiento de la imagen de nuestros productos y servicios.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-29-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-155-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Diseñar e implementar programas de promoción, '
                . 'servicio y asesoría técnico-comercial a clientes, que permitan el '
                . 'fortalecimiento de la imagen de nuestros productos y servicios.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-30-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-156-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.1.5
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover el desarrollo de infraestructura, para'
                . ' el manejo y distribución de productos químicos y petroquímicos, '
                . 'incentivando la inversión del Estado y sector privado en capacidades de'
                . ' almacenaje y transporte del sector.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-25-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-157-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover el desarrollo de infraestructura, para'
                . ' el manejo y distribución de productos químicos y petroquímicos, '
                . 'incentivando la inversión del Estado y sector privado en capacidades de'
                . ' almacenaje y transporte del sector.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-26-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-158-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover el desarrollo de infraestructura, para'
                . ' el manejo y distribución de productos químicos y petroquímicos, '
                . 'incentivando la inversión del Estado y sector privado en capacidades de'
                . ' almacenaje y transporte del sector.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-27-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-159-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover el desarrollo de infraestructura, para'
                . ' el manejo y distribución de productos químicos y petroquímicos, '
                . 'incentivando la inversión del Estado y sector privado en capacidades de'
                . ' almacenaje y transporte del sector.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-28-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-160-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover el desarrollo de infraestructura, para'
                . ' el manejo y distribución de productos químicos y petroquímicos, '
                . 'incentivando la inversión del Estado y sector privado en capacidades de'
                . ' almacenaje y transporte del sector.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-29-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-161-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover el desarrollo de infraestructura, para'
                . ' el manejo y distribución de productos químicos y petroquímicos, '
                . 'incentivando la inversión del Estado y sector privado en capacidades de'
                . ' almacenaje y transporte del sector.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-30-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-162-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.1.6
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Aplicación de políticas comerciales y de '
                . 'mercadeo que dinamicen las ventas y la atención del mercado.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-25-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-163-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Aplicación de políticas comerciales y de '
                . 'mercadeo que dinamicen las ventas y la atención del mercado.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-26-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-164-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Aplicación de políticas comerciales y de '
                . 'mercadeo que dinamicen las ventas y la atención del mercado.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-27-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-165-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Aplicación de políticas comerciales y de '
                . 'mercadeo que dinamicen las ventas y la atención del mercado.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-28-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-166-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Aplicación de políticas comerciales y de '
                . 'mercadeo que dinamicen las ventas y la atención del mercado.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-29-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-167-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Aplicación de políticas comerciales y de '
                . 'mercadeo que dinamicen las ventas y la atención del mercado.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-30-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-168-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.1.7
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Ejecutar planes de venta basados en un balance '
                . 'actualizado de los requerimientos de productos químicos y '
                . 'petroquímicos de los circulos productivos aguas abajo.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-25-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-169-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Ejecutar planes de venta basados en un balance '
                . 'actualizado de los requerimientos de productos químicos y '
                . 'petroquímicos de los circulos productivos aguas abajo.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-26-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-170-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Ejecutar planes de venta basados en un balance '
                . 'actualizado de los requerimientos de productos químicos y '
                . 'petroquímicos de los circulos productivos aguas abajo.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-27-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-171-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Ejecutar planes de venta basados en un balance '
                . 'actualizado de los requerimientos de productos químicos y '
                . 'petroquímicos de los circulos productivos aguas abajo.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-28-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-172-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Ejecutar planes de venta basados en un balance '
                . 'actualizado de los requerimientos de productos químicos y '
                . 'petroquímicos de los circulos productivos aguas abajo.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-29-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-173-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Ejecutar planes de venta basados en un balance '
                . 'actualizado de los requerimientos de productos químicos y '
                . 'petroquímicos de los circulos productivos aguas abajo.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-30-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-174-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.2.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer condiciones de precios que garanticen'
                . ' la rentabilidad de la operación comercial.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-31-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-175-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer condiciones de precios que garanticen'
                . ' la rentabilidad de la operación comercial.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-32-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-176-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer condiciones de precios que garanticen'
                . ' la rentabilidad de la operación comercial.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-33-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-177-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer condiciones de precios que garanticen'
                . ' la rentabilidad de la operación comercial.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-34-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-178-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer condiciones de precios que garanticen'
                . ' la rentabilidad de la operación comercial.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-35-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-179-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer condiciones de precios que garanticen'
                . ' la rentabilidad de la operación comercial.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-36-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-180-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.2.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer y mantener contratos anuales de '
                . 'suministro con clientes internacionales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-31-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-181-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer y mantener contratos anuales de '
                . 'suministro con clientes internacionales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-32-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-182-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer y mantener contratos anuales de '
                . 'suministro con clientes internacionales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-33-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-183-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer y mantener contratos anuales de '
                . 'suministro con clientes internacionales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-34-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-184-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer y mantener contratos anuales de '
                . 'suministro con clientes internacionales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-35-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-185-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer y mantener contratos anuales de '
                . 'suministro con clientes internacionales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-36-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-186-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.2.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer en los trabajadores la cultura de la '
                . 'calidad y el enfoque al cliente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-31-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-187-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer en los trabajadores la cultura de la '
                . 'calidad y el enfoque al cliente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-32-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-188-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer en los trabajadores la cultura de la '
                . 'calidad y el enfoque al cliente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-33-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-189-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer en los trabajadores la cultura de la '
                . 'calidad y el enfoque al cliente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-34-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-190-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer en los trabajadores la cultura de la '
                . 'calidad y el enfoque al cliente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-35-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-191-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer en los trabajadores la cultura de la '
                . 'calidad y el enfoque al cliente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-36-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-192-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.2.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Proveer servicios logísticos competitivos para '
                . 'la optimización de las redes de distribución.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-31-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-193-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Proveer servicios logísticos competitivos para '
                . 'la optimización de las redes de distribución.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-32-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-194-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Proveer servicios logísticos competitivos para '
                . 'la optimización de las redes de distribución.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-33-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-195-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Proveer servicios logísticos competitivos para '
                . 'la optimización de las redes de distribución.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-34-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-196-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Proveer servicios logísticos competitivos para '
                . 'la optimización de las redes de distribución.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-35-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-197-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Proveer servicios logísticos competitivos para '
                . 'la optimización de las redes de distribución.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-36-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-198-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.2.5
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover programas de servicio técnico de '
                . 'nuestros productos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-31-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-199-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover programas de servicio técnico de '
                . 'nuestros productos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-32-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-200-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover programas de servicio técnico de '
                . 'nuestros productos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-33-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-201-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover programas de servicio técnico de '
                . 'nuestros productos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-34-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-202-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover programas de servicio técnico de '
                . 'nuestros productos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-35-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-203-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover programas de servicio técnico de '
                . 'nuestros productos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-36-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-204-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.2.6
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Incrementar la presencia en los espacios de '
                . 'cooperación comercial internacional en los que participa la Nación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-31-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-205-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Incrementar la presencia en los espacios de '
                . 'cooperación comercial internacional en los que participa la Nación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-32-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-206-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Incrementar la presencia en los espacios de '
                . 'cooperación comercial internacional en los que participa la Nación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-33-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-207-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Incrementar la presencia en los espacios de '
                . 'cooperación comercial internacional en los que participa la Nación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-34-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-208-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Incrementar la presencia en los espacios de '
                . 'cooperación comercial internacional en los que participa la Nación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-35-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-209-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Incrementar la presencia en los espacios de '
                . 'cooperación comercial internacional en los que participa la Nación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-36-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-210-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.2.7
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar programas anuales de acercamiento y '
                . 'comunicación con los clientes internacionales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-31-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-211-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar programas anuales de acercamiento y '
                . 'comunicación con los clientes internacionales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-32-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-212-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar programas anuales de acercamiento y '
                . 'comunicación con los clientes internacionales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-33-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-213-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar programas anuales de acercamiento y '
                . 'comunicación con los clientes internacionales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-34-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-214-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar programas anuales de acercamiento y '
                . 'comunicación con los clientes internacionales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-35-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-215-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar programas anuales de acercamiento y '
                . 'comunicación con los clientes internacionales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-36-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-216-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.2.8
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Atender los requerimientos que se originen de los '
                . 'acuerdos de cooperación comercial con países y sectores pertenecientes '
                . 'a alianzas estratégicas de la Nación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-31-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-217-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Atender los requerimientos que se originen de los '
                . 'acuerdos de cooperación comercial con países y sectores pertenecientes '
                . 'a alianzas estratégicas de la Nación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-32-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-218-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Atender los requerimientos que se originen de los '
                . 'acuerdos de cooperación comercial con países y sectores pertenecientes '
                . 'a alianzas estratégicas de la Nación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-33-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-219-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Atender los requerimientos que se originen de los '
                . 'acuerdos de cooperación comercial con países y sectores pertenecientes '
                . 'a alianzas estratégicas de la Nación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-34-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-220-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Atender los requerimientos que se originen de los '
                . 'acuerdos de cooperación comercial con países y sectores pertenecientes '
                . 'a alianzas estratégicas de la Nación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-35-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-221-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Atender los requerimientos que se originen de los '
                . 'acuerdos de cooperación comercial con países y sectores pertenecientes '
                . 'a alianzas estratégicas de la Nación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-36-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-222-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.2.9
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Ejecutar planes de venta basados en la '
                . 'disponibilidad de productos petroquímicos para la exportación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-31-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-223-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Ejecutar planes de venta basados en la '
                . 'disponibilidad de productos petroquímicos para la exportación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-32-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-224-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Ejecutar planes de venta basados en la '
                . 'disponibilidad de productos petroquímicos para la exportación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-33-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-225-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Ejecutar planes de venta basados en la '
                . 'disponibilidad de productos petroquímicos para la exportación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-34-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-226-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Ejecutar planes de venta basados en la '
                . 'disponibilidad de productos petroquímicos para la exportación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-35-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-227-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Ejecutar planes de venta basados en la '
                . 'disponibilidad de productos petroquímicos para la exportación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-36-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-228-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.3.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Identificar y evaluar mercados y negocios posibles.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-37-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-229-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Identificar y evaluar mercados y negocios posibles.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-38-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-230-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Identificar y evaluar mercados y negocios posibles.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-39-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-231-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Identificar y evaluar mercados y negocios posibles.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-40-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-232-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Identificar y evaluar mercados y negocios posibles.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-41-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-233-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Identificar y evaluar mercados y negocios posibles.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-42-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-234-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.3.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar productos y servicios para mejorar '
                . 'la atención integral de los clientes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-37-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-235-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar productos y servicios para mejorar '
                . 'la atención integral de los clientes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-38-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-236-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar productos y servicios para mejorar '
                . 'la atención integral de los clientes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-39-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-237-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar productos y servicios para mejorar '
                . 'la atención integral de los clientes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-40-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-238-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar productos y servicios para mejorar '
                . 'la atención integral de los clientes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-41-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-239-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar productos y servicios para mejorar '
                . 'la atención integral de los clientes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-42-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-240-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.3.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer el análisis del entorno comercial e '
                . 'inteligencia de mercado.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-37-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-241-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer el análisis del entorno comercial e '
                . 'inteligencia de mercado.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-38-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-242-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer el análisis del entorno comercial e '
                . 'inteligencia de mercado.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-39-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-243-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer el análisis del entorno comercial e '
                . 'inteligencia de mercado.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-40-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-244-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer el análisis del entorno comercial e '
                . 'inteligencia de mercado.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-41-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-245-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer el análisis del entorno comercial e '
                . 'inteligencia de mercado.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-42-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-246-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.3.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Incentivar el desarrollo aguas abajo de las '
                . 'empresas relacionadas con la petroquímica (Filiales y Empresas Mixtas), '
                . 'que permitan alcanzar niveles de competitividad del sector transformador '
                . 'para colocar sus excedentes en el mercado internacional.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-37-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-247-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Incentivar el desarrollo aguas abajo de las '
                . 'empresas relacionadas con la petroquímica (Filiales y Empresas Mixtas), '
                . 'que permitan alcanzar niveles de competitividad del sector transformador '
                . 'para colocar sus excedentes en el mercado internacional.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-38-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-248-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Incentivar el desarrollo aguas abajo de las '
                . 'empresas relacionadas con la petroquímica (Filiales y Empresas Mixtas), '
                . 'que permitan alcanzar niveles de competitividad del sector transformador '
                . 'para colocar sus excedentes en el mercado internacional.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-39-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-249-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Incentivar el desarrollo aguas abajo de las '
                . 'empresas relacionadas con la petroquímica (Filiales y Empresas Mixtas), '
                . 'que permitan alcanzar niveles de competitividad del sector transformador '
                . 'para colocar sus excedentes en el mercado internacional.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-40-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-250-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Incentivar el desarrollo aguas abajo de las '
                . 'empresas relacionadas con la petroquímica (Filiales y Empresas Mixtas), '
                . 'que permitan alcanzar niveles de competitividad del sector transformador '
                . 'para colocar sus excedentes en el mercado internacional.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-41-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-251-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Incentivar el desarrollo aguas abajo de las '
                . 'empresas relacionadas con la petroquímica (Filiales y Empresas Mixtas), '
                . 'que permitan alcanzar niveles de competitividad del sector transformador '
                . 'para colocar sus excedentes en el mercado internacional.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-42-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-252-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //4.1.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Elaborar y hacer seguimiento al Plan de Negocio '
                . 'Petroquímico.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-43-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-253-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Elaborar y hacer seguimiento al Plan de Negocio '
                . 'Petroquímico.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-44-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-254-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Elaborar y hacer seguimiento al Plan de Negocio '
                . 'Petroquímico.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-45-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-255-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Elaborar y hacer seguimiento al Plan de Negocio '
                . 'Petroquímico.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-46-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-256-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Elaborar y hacer seguimiento al Plan de Negocio '
                . 'Petroquímico.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-47-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-257-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Elaborar y hacer seguimiento al Plan de Negocio '
                . 'Petroquímico.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-48-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-258-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //4.1.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar el cumplimiento de los planes de '
                . 'ejecución de proyectos desarrollados en el Plan Petroquímico Nacional.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-43-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-259-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar el cumplimiento de los planes de '
                . 'ejecución de proyectos desarrollados en el Plan Petroquímico Nacional.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-44-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-260-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar el cumplimiento de los planes de '
                . 'ejecución de proyectos desarrollados en el Plan Petroquímico Nacional.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-45-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-261-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar el cumplimiento de los planes de '
                . 'ejecución de proyectos desarrollados en el Plan Petroquímico Nacional.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-46-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-262-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar el cumplimiento de los planes de '
                . 'ejecución de proyectos desarrollados en el Plan Petroquímico Nacional.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-47-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-263-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar el cumplimiento de los planes de '
                . 'ejecución de proyectos desarrollados en el Plan Petroquímico Nacional.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-48-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-264-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //4.1.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover la definición de proyectos orientados al '
                . 'incremento de las capacidades de los productos actuales que satisfagan la '
                . 'demanda nacional con criterio de sostenibilidad económica.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-43-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-265-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover la definición de proyectos orientados al '
                . 'incremento de las capacidades de los productos actuales que satisfagan la '
                . 'demanda nacional con criterio de sostenibilidad económica.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-44-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-266-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover la definición de proyectos orientados al '
                . 'incremento de las capacidades de los productos actuales que satisfagan la '
                . 'demanda nacional con criterio de sostenibilidad económica.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-45-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-267-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover la definición de proyectos orientados al '
                . 'incremento de las capacidades de los productos actuales que satisfagan la '
                . 'demanda nacional con criterio de sostenibilidad económica.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-46-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-268-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover la definición de proyectos orientados al '
                . 'incremento de las capacidades de los productos actuales que satisfagan la '
                . 'demanda nacional con criterio de sostenibilidad económica.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-47-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-269-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover la definición de proyectos orientados al '
                . 'incremento de las capacidades de los productos actuales que satisfagan la '
                . 'demanda nacional con criterio de sostenibilidad económica.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-48-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-270-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //4.1.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Integrar las herramientas tecnológicas que soportan'
                . ' las operaciones e innovación petroquímica con los planes de crecimiento de '
                . 'la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-43-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-271-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Integrar las herramientas tecnológicas que soportan'
                . ' las operaciones e innovación petroquímica con los planes de crecimiento de '
                . 'la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-44-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-272-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Integrar las herramientas tecnológicas que soportan'
                . ' las operaciones e innovación petroquímica con los planes de crecimiento de '
                . 'la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-45-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-273-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Integrar las herramientas tecnológicas que soportan'
                . ' las operaciones e innovación petroquímica con los planes de crecimiento de '
                . 'la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-46-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-274-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Integrar las herramientas tecnológicas que soportan'
                . ' las operaciones e innovación petroquímica con los planes de crecimiento de '
                . 'la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-47-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-275-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Integrar las herramientas tecnológicas que soportan'
                . ' las operaciones e innovación petroquímica con los planes de crecimiento de '
                . 'la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-48-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-276-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //4.1.5
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar líneas de investigación e innovación petroquímica'
                . ' para el incremento y mejora de nuestras actuales áreas del negocio.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-43-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-277-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar líneas de investigación e innovación petroquímica'
                . ' para el incremento y mejora de nuestras actuales áreas del negocio.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-44-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-278-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar líneas de investigación e innovación petroquímica'
                . ' para el incremento y mejora de nuestras actuales áreas del negocio.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-45-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-279-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar líneas de investigación e innovación petroquímica'
                . ' para el incremento y mejora de nuestras actuales áreas del negocio.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-46-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-280-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar líneas de investigación e innovación petroquímica'
                . ' para el incremento y mejora de nuestras actuales áreas del negocio.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-47-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-281-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar líneas de investigación e innovación petroquímica'
                . ' para el incremento y mejora de nuestras actuales áreas del negocio.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-48-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-282-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //4.1.6
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer alianzas, redes de investigación y desarrollo '
                . 'tecnológico con empresas, organismos e instituciones en el campo petroquímico a nivel '
                . 'nacional e internacional, para incrementar la producción en las líneas actuales del '
                . 'negocio.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-43-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-283-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer alianzas, redes de investigación y desarrollo '
                . 'tecnológico con empresas, organismos e instituciones en el campo petroquímico a nivel '
                . 'nacional e internacional, para incrementar la producción en las líneas actuales del '
                . 'negocio.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-44-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-284-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer alianzas, redes de investigación y desarrollo '
                . 'tecnológico con empresas, organismos e instituciones en el campo petroquímico a nivel '
                . 'nacional e internacional, para incrementar la producción en las líneas actuales del '
                . 'negocio.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-45-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-285-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer alianzas, redes de investigación y desarrollo '
                . 'tecnológico con empresas, organismos e instituciones en el campo petroquímico a nivel '
                . 'nacional e internacional, para incrementar la producción en las líneas actuales del '
                . 'negocio.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-46-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-286-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer alianzas, redes de investigación y desarrollo '
                . 'tecnológico con empresas, organismos e instituciones en el campo petroquímico a nivel '
                . 'nacional e internacional, para incrementar la producción en las líneas actuales del '
                . 'negocio.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-47-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-287-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer alianzas, redes de investigación y desarrollo '
                . 'tecnológico con empresas, organismos e instituciones en el campo petroquímico a nivel '
                . 'nacional e internacional, para incrementar la producción en las líneas actuales del '
                . 'negocio.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-48-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-288-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //4.2.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar mecanismos de identificación de oportunidades '
                . 'del entorno y de potencialidades de proyectos conexos a la industria petroquímica.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-49-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-289-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar mecanismos de identificación de oportunidades '
                . 'del entorno y de potencialidades de proyectos conexos a la industria petroquímica.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-50-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-290-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar mecanismos de identificación de oportunidades '
                . 'del entorno y de potencialidades de proyectos conexos a la industria petroquímica.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-51-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-291-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar mecanismos de identificación de oportunidades '
                . 'del entorno y de potencialidades de proyectos conexos a la industria petroquímica.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-52-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-292-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar mecanismos de identificación de oportunidades '
                . 'del entorno y de potencialidades de proyectos conexos a la industria petroquímica.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-53-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-293-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar mecanismos de identificación de oportunidades '
                . 'del entorno y de potencialidades de proyectos conexos a la industria petroquímica.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-54-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-294-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //4.2.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Definir proyectos de diversificación acorde a las '
                . 'oportunidades de la Corporación y la factibilidad técnico-económica.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-49-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-295-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Definir proyectos de diversificación acorde a las '
                . 'oportunidades de la Corporación y la factibilidad técnico-económica.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-50-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-296-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Definir proyectos de diversificación acorde a las '
                . 'oportunidades de la Corporación y la factibilidad técnico-económica.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-51-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-297-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Definir proyectos de diversificación acorde a las '
                . 'oportunidades de la Corporación y la factibilidad técnico-económica.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-52-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-298-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Definir proyectos de diversificación acorde a las '
                . 'oportunidades de la Corporación y la factibilidad técnico-económica.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-53-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-299-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Definir proyectos de diversificación acorde a las '
                . 'oportunidades de la Corporación y la factibilidad técnico-económica.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-54-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-300-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //4.2.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar líneas de investigación e innovación petroquímica'
                . ' para la creación de nuevos productos, servicios y aplicaciones tecnológicas.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-49-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-301-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar líneas de investigación e innovación petroquímica'
                . ' para la creación de nuevos productos, servicios y aplicaciones tecnológicas.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-50-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-302-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar líneas de investigación e innovación petroquímica'
                . ' para la creación de nuevos productos, servicios y aplicaciones tecnológicas.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-51-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-303-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar líneas de investigación e innovación petroquímica'
                . ' para la creación de nuevos productos, servicios y aplicaciones tecnológicas.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-52-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-304-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar líneas de investigación e innovación petroquímica'
                . ' para la creación de nuevos productos, servicios y aplicaciones tecnológicas.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-53-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-305-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar líneas de investigación e innovación petroquímica'
                . ' para la creación de nuevos productos, servicios y aplicaciones tecnológicas.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-54-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-306-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //4.2.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer alianzas, redes de investigación y desarrollo '
                . 'tecnológico con empresas, organismos e instituciones en el campo petroquímico a nivel '
                . 'nacional e internacional, para la diversificación del negocio.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-49-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-307-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer alianzas, redes de investigación y desarrollo '
                . 'tecnológico con empresas, organismos e instituciones en el campo petroquímico a nivel '
                . 'nacional e internacional, para la diversificación del negocio.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-50-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-308-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer alianzas, redes de investigación y desarrollo '
                . 'tecnológico con empresas, organismos e instituciones en el campo petroquímico a nivel '
                . 'nacional e internacional, para la diversificación del negocio.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-51-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-309-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer alianzas, redes de investigación y desarrollo '
                . 'tecnológico con empresas, organismos e instituciones en el campo petroquímico a nivel '
                . 'nacional e internacional, para la diversificación del negocio.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-52-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-310-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer alianzas, redes de investigación y desarrollo '
                . 'tecnológico con empresas, organismos e instituciones en el campo petroquímico a nivel '
                . 'nacional e internacional, para la diversificación del negocio.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-53-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-311-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer alianzas, redes de investigación y desarrollo '
                . 'tecnológico con empresas, organismos e instituciones en el campo petroquímico a nivel '
                . 'nacional e internacional, para la diversificación del negocio.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-54-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-312-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //4.2.5
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar capacidades científico, técnicas e '
                . 'institucionales para impulsar proyectos de investigación petroquímica, para la '
                . 'sustitución de importaciones, manejo adecuado de los recursos naturales que '
                . 'contribuyan con la soberanía y seguridad de la nación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-49-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-313-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar capacidades científico, técnicas e '
                . 'institucionales para impulsar proyectos de investigación petroquímica, para la '
                . 'sustitución de importaciones, manejo adecuado de los recursos naturales que '
                . 'contribuyan con la soberanía y seguridad de la nación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-50-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-314-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar capacidades científico, técnicas e '
                . 'institucionales para impulsar proyectos de investigación petroquímica, para la '
                . 'sustitución de importaciones, manejo adecuado de los recursos naturales que '
                . 'contribuyan con la soberanía y seguridad de la nación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-51-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-315-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar capacidades científico, técnicas e '
                . 'institucionales para impulsar proyectos de investigación petroquímica, para la '
                . 'sustitución de importaciones, manejo adecuado de los recursos naturales que '
                . 'contribuyan con la soberanía y seguridad de la nación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-52-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-316-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar capacidades científico, técnicas e '
                . 'institucionales para impulsar proyectos de investigación petroquímica, para la '
                . 'sustitución de importaciones, manejo adecuado de los recursos naturales que '
                . 'contribuyan con la soberanía y seguridad de la nación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-53-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-317-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar capacidades científico, técnicas e '
                . 'institucionales para impulsar proyectos de investigación petroquímica, para la '
                . 'sustitución de importaciones, manejo adecuado de los recursos naturales que '
                . 'contribuyan con la soberanía y seguridad de la nación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-54-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-318-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.1.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar en la Corporación el Sistema Integrado de '
                . 'Gestión de Riesgos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-55-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-319-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar en la Corporación el Sistema Integrado de '
                . 'Gestión de Riesgos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-56-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-320-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar en la Corporación el Sistema Integrado de '
                . 'Gestión de Riesgos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-57-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-321-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar en la Corporación el Sistema Integrado de '
                . 'Gestión de Riesgos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-58-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-322-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar en la Corporación el Sistema Integrado de '
                . 'Gestión de Riesgos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-59-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-323-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar en la Corporación el Sistema Integrado de '
                . 'Gestión de Riesgos.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-60-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-324-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.1.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover el uso de tecnologías, procesos, productos, '
                . 'materiales, equipos y sistemas, ambientalmente amigables y seguros.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-55-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-325-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover el uso de tecnologías, procesos, productos, '
                . 'materiales, equipos y sistemas, ambientalmente amigables y seguros.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-56-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-326-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover el uso de tecnologías, procesos, productos, '
                . 'materiales, equipos y sistemas, ambientalmente amigables y seguros.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-57-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-327-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover el uso de tecnologías, procesos, productos, '
                . 'materiales, equipos y sistemas, ambientalmente amigables y seguros.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-58-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-328-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover el uso de tecnologías, procesos, productos, '
                . 'materiales, equipos y sistemas, ambientalmente amigables y seguros.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-59-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-329-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover el uso de tecnologías, procesos, productos, '
                . 'materiales, equipos y sistemas, ambientalmente amigables y seguros.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-60-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-330-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.1.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar la prestación de los servicios de salud a los '
                . 'trabajadores,  trabajadoras, jubilados en las Clínicas Industriales y a los '
                . 'beneficiarios de los Planes de Salud.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-55-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-331-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar la prestación de los servicios de salud a los '
                . 'trabajadores,  trabajadoras, jubilados en las Clínicas Industriales y a los '
                . 'beneficiarios de los Planes de Salud.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-56-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-332-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar la prestación de los servicios de salud a los '
                . 'trabajadores,  trabajadoras, jubilados en las Clínicas Industriales y a los '
                . 'beneficiarios de los Planes de Salud.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-57-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-333-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar la prestación de los servicios de salud a los '
                . 'trabajadores,  trabajadoras, jubilados en las Clínicas Industriales y a los '
                . 'beneficiarios de los Planes de Salud.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-58-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-334-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar la prestación de los servicios de salud a los '
                . 'trabajadores,  trabajadoras, jubilados en las Clínicas Industriales y a los '
                . 'beneficiarios de los Planes de Salud.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-59-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-335-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar la prestación de los servicios de salud a los '
                . 'trabajadores,  trabajadoras, jubilados en las Clínicas Industriales y a los '
                . 'beneficiarios de los Planes de Salud.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-60-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-336-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.2.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar competencias en el personal en materia de SHA, '
                . 'con énfasis en la prevención y el manejo eficiente de los riesgos laborales, '
                . 'ambientales y a la salud.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-61-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-337-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar competencias en el personal en materia de SHA, '
                . 'con énfasis en la prevención y el manejo eficiente de los riesgos laborales, '
                . 'ambientales y a la salud.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-62-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-338-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar competencias en el personal en materia de SHA, '
                . 'con énfasis en la prevención y el manejo eficiente de los riesgos laborales, '
                . 'ambientales y a la salud.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-63-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-339-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar competencias en el personal en materia de SHA, '
                . 'con énfasis en la prevención y el manejo eficiente de los riesgos laborales, '
                . 'ambientales y a la salud.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-64-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-340-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar competencias en el personal en materia de SHA, '
                . 'con énfasis en la prevención y el manejo eficiente de los riesgos laborales, '
                . 'ambientales y a la salud.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-65-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-341-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar competencias en el personal en materia de SHA, '
                . 'con énfasis en la prevención y el manejo eficiente de los riesgos laborales, '
                . 'ambientales y a la salud.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-66-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-342-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.2.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer el control preventivo de todas las instalaciones'
                . ' y la seguridad de todo su personal y comunidades adyacentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-61-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-343-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer el control preventivo de todas las instalaciones'
                . ' y la seguridad de todo su personal y comunidades adyacentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-62-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-344-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer el control preventivo de todas las instalaciones'
                . ' y la seguridad de todo su personal y comunidades adyacentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-63-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-345-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer el control preventivo de todas las instalaciones'
                . ' y la seguridad de todo su personal y comunidades adyacentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-64-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-346-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer el control preventivo de todas las instalaciones'
                . ' y la seguridad de todo su personal y comunidades adyacentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-65-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-347-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer el control preventivo de todas las instalaciones'
                . ' y la seguridad de todo su personal y comunidades adyacentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-66-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-348-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.2.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos de validación de productos, materias '
                . 'primas e insumos, cuyas especificaciones, uso, transporte y disposición final como '
                . 'desechos no impacten la salud de las personas ni al ambiente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-61-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-349-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos de validación de productos, materias '
                . 'primas e insumos, cuyas especificaciones, uso, transporte y disposición final como '
                . 'desechos no impacten la salud de las personas ni al ambiente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-62-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-350-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos de validación de productos, materias '
                . 'primas e insumos, cuyas especificaciones, uso, transporte y disposición final como '
                . 'desechos no impacten la salud de las personas ni al ambiente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-63-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-351-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos de validación de productos, materias '
                . 'primas e insumos, cuyas especificaciones, uso, transporte y disposición final como '
                . 'desechos no impacten la salud de las personas ni al ambiente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-64-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-352-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos de validación de productos, materias '
                . 'primas e insumos, cuyas especificaciones, uso, transporte y disposición final como '
                . 'desechos no impacten la salud de las personas ni al ambiente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-65-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-353-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos de validación de productos, materias '
                . 'primas e insumos, cuyas especificaciones, uso, transporte y disposición final como '
                . 'desechos no impacten la salud de las personas ni al ambiente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-66-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-354-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.2.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Mantener comunicaciones efectivas con las comunidades del '
                . 'entorno, en relación a riesgos y respuesta ante emergencias.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-61-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-355-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Mantener comunicaciones efectivas con las comunidades del '
                . 'entorno, en relación a riesgos y respuesta ante emergencias.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-62-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-356-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Mantener comunicaciones efectivas con las comunidades del '
                . 'entorno, en relación a riesgos y respuesta ante emergencias.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-63-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-357-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Mantener comunicaciones efectivas con las comunidades del '
                . 'entorno, en relación a riesgos y respuesta ante emergencias.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-64-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-358-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Mantener comunicaciones efectivas con las comunidades del '
                . 'entorno, en relación a riesgos y respuesta ante emergencias.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-65-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-359-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Mantener comunicaciones efectivas con las comunidades del '
                . 'entorno, en relación a riesgos y respuesta ante emergencias.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-66-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-360-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.2.5
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos efectivos que permitan el registro, '
                . 'control y seguimiento de los incidentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-61-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-361-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos efectivos que permitan el registro, '
                . 'control y seguimiento de los incidentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-62-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-362-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos efectivos que permitan el registro, '
                . 'control y seguimiento de los incidentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-63-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-363-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos efectivos que permitan el registro, '
                . 'control y seguimiento de los incidentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-64-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-364-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos efectivos que permitan el registro, '
                . 'control y seguimiento de los incidentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-65-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-365-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos efectivos que permitan el registro, '
                . 'control y seguimiento de los incidentes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-66-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-366-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.2.6
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar mecanismos para la Promoción, Prevención, y '
                . 'Rehabilitación en Salud Ocupacional e Integral de los trabajadores y trabajadoras.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-61-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-367-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar mecanismos para la Promoción, Prevención, y '
                . 'Rehabilitación en Salud Ocupacional e Integral de los trabajadores y trabajadoras.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-62-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-368-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar mecanismos para la Promoción, Prevención, y '
                . 'Rehabilitación en Salud Ocupacional e Integral de los trabajadores y trabajadoras.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-63-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-369-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar mecanismos para la Promoción, Prevención, y '
                . 'Rehabilitación en Salud Ocupacional e Integral de los trabajadores y trabajadoras.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-64-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-370-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar mecanismos para la Promoción, Prevención, y '
                . 'Rehabilitación en Salud Ocupacional e Integral de los trabajadores y trabajadoras.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-65-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-371-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar mecanismos para la Promoción, Prevención, y '
                . 'Rehabilitación en Salud Ocupacional e Integral de los trabajadores y trabajadoras.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-66-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-372-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.3.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer los mecanismos de cooperación con las autoridades'
                . ' y entes reguladores del ambiente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-67-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-373-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer los mecanismos de cooperación con las autoridades'
                . ' y entes reguladores del ambiente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-68-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-374-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer los mecanismos de cooperación con las autoridades'
                . ' y entes reguladores del ambiente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-69-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-375-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer los mecanismos de cooperación con las autoridades'
                . ' y entes reguladores del ambiente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-70-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-376-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer los mecanismos de cooperación con las autoridades'
                . ' y entes reguladores del ambiente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-71-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-377-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer los mecanismos de cooperación con las autoridades'
                . ' y entes reguladores del ambiente.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-72-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-378-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.3.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Definir planes para el uso racional de la energía, y en '
                . 'general, de los recursos naturales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-67-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-379-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Definir planes para el uso racional de la energía, y en '
                . 'general, de los recursos naturales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-68-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-380-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Definir planes para el uso racional de la energía, y en '
                . 'general, de los recursos naturales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-69-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-381-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Definir planes para el uso racional de la energía, y en '
                . 'general, de los recursos naturales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-70-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-382-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Definir planes para el uso racional de la energía, y en '
                . 'general, de los recursos naturales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-71-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-383-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Definir planes para el uso racional de la energía, y en '
                . 'general, de los recursos naturales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-72-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-384-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.3.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar evaluaciones y planes de manejo ambiental para '
                . 'prevenir, mitigar, controlar y compensar impactos ambientales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-67-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-385-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar evaluaciones y planes de manejo ambiental para '
                . 'prevenir, mitigar, controlar y compensar impactos ambientales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-68-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-386-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar evaluaciones y planes de manejo ambiental para '
                . 'prevenir, mitigar, controlar y compensar impactos ambientales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-69-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-387-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar evaluaciones y planes de manejo ambiental para '
                . 'prevenir, mitigar, controlar y compensar impactos ambientales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-70-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-388-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar evaluaciones y planes de manejo ambiental para '
                . 'prevenir, mitigar, controlar y compensar impactos ambientales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-71-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-389-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar evaluaciones y planes de manejo ambiental para '
                . 'prevenir, mitigar, controlar y compensar impactos ambientales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-72-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-390-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.3.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar planes de conservación y repoblación forestal '
                . 'en las áreas de influencia de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-67-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-391-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar planes de conservación y repoblación forestal '
                . 'en las áreas de influencia de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-68-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-392-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar planes de conservación y repoblación forestal '
                . 'en las áreas de influencia de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-69-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-393-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar planes de conservación y repoblación forestal '
                . 'en las áreas de influencia de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-70-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-394-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar planes de conservación y repoblación forestal '
                . 'en las áreas de influencia de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-71-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-395-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar planes de conservación y repoblación forestal '
                . 'en las áreas de influencia de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-72-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-396-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //6.1.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar un modelo de Plan de Carrera para los '
                . 'trabajadores de la Corporación; así como, un Plan de Sucesión en las posiciones claves,'
                . ' que permita desarrollar las competencias del supervisor como mentor, coach y/o '
                . 'facilitador de su equipo.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-73-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-397-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar un modelo de Plan de Carrera para los '
                . 'trabajadores de la Corporación; así como, un Plan de Sucesión en las posiciones claves,'
                . ' que permita desarrollar las competencias del supervisor como mentor, coach y/o '
                . 'facilitador de su equipo.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-74-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-398-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar un modelo de Plan de Carrera para los '
                . 'trabajadores de la Corporación; así como, un Plan de Sucesión en las posiciones claves,'
                . ' que permita desarrollar las competencias del supervisor como mentor, coach y/o '
                . 'facilitador de su equipo.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-75-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-399-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar un modelo de Plan de Carrera para los '
                . 'trabajadores de la Corporación; así como, un Plan de Sucesión en las posiciones claves,'
                . ' que permita desarrollar las competencias del supervisor como mentor, coach y/o '
                . 'facilitador de su equipo.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-76-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-400-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar un modelo de Plan de Carrera para los '
                . 'trabajadores de la Corporación; así como, un Plan de Sucesión en las posiciones claves,'
                . ' que permita desarrollar las competencias del supervisor como mentor, coach y/o '
                . 'facilitador de su equipo.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-77-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-401-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar un modelo de Plan de Carrera para los '
                . 'trabajadores de la Corporación; así como, un Plan de Sucesión en las posiciones claves,'
                . ' que permita desarrollar las competencias del supervisor como mentor, coach y/o '
                . 'facilitador de su equipo.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-78-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-402-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //6.1.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar los procesos de selección, formación y desarrollo '
                . 'del personal, adaptándolos al modelo de competencias.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-73-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-403-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar los procesos de selección, formación y desarrollo '
                . 'del personal, adaptándolos al modelo de competencias.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-74-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-404-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar los procesos de selección, formación y desarrollo '
                . 'del personal, adaptándolos al modelo de competencias.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-75-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-405-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar los procesos de selección, formación y desarrollo '
                . 'del personal, adaptándolos al modelo de competencias.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-76-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-406-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar los procesos de selección, formación y desarrollo '
                . 'del personal, adaptándolos al modelo de competencias.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-77-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-407-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar los procesos de selección, formación y desarrollo '
                . 'del personal, adaptándolos al modelo de competencias.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-78-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-408-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //6.1.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Ampliar los canales de comunicación y acompañamiento de las'
                . ' líneas supervisorias como coadministrador de personal para una gestión de recursos'
                . ' humanos efectiva.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-73-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-409-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Ampliar los canales de comunicación y acompañamiento de las'
                . ' líneas supervisorias como coadministrador de personal para una gestión de recursos'
                . ' humanos efectiva.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-74-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-410-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Ampliar los canales de comunicación y acompañamiento de las'
                . ' líneas supervisorias como coadministrador de personal para una gestión de recursos'
                . ' humanos efectiva.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-75-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-411-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Ampliar los canales de comunicación y acompañamiento de las'
                . ' líneas supervisorias como coadministrador de personal para una gestión de recursos'
                . ' humanos efectiva.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-76-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-412-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Ampliar los canales de comunicación y acompañamiento de las'
                . ' líneas supervisorias como coadministrador de personal para una gestión de recursos'
                . ' humanos efectiva.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-77-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-413-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Ampliar los canales de comunicación y acompañamiento de las'
                . ' líneas supervisorias como coadministrador de personal para una gestión de recursos'
                . ' humanos efectiva.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-78-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-414-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //6.1.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer alianzas con instituciones nacionales e '
                . 'internacionales para fortalecer el proceso de formación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-73-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-415-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer alianzas con instituciones nacionales e '
                . 'internacionales para fortalecer el proceso de formación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-74-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-416-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer alianzas con instituciones nacionales e '
                . 'internacionales para fortalecer el proceso de formación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-75-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-417-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer alianzas con instituciones nacionales e '
                . 'internacionales para fortalecer el proceso de formación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-76-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-418-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer alianzas con instituciones nacionales e '
                . 'internacionales para fortalecer el proceso de formación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-77-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-419-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer alianzas con instituciones nacionales e '
                . 'internacionales para fortalecer el proceso de formación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-78-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-420-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //6.2.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover, divulgar y promocionar la misión, visión, '
                . 'objetivos y valores de Pequiven, con el fin de consolidar la imagen e identidad '
                . 'corporativa, dirigido a potenciar un clima organizacional positivo.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-79-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-421-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover, divulgar y promocionar la misión, visión, '
                . 'objetivos y valores de Pequiven, con el fin de consolidar la imagen e identidad '
                . 'corporativa, dirigido a potenciar un clima organizacional positivo.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-80-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-422-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover, divulgar y promocionar la misión, visión, '
                . 'objetivos y valores de Pequiven, con el fin de consolidar la imagen e identidad '
                . 'corporativa, dirigido a potenciar un clima organizacional positivo.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-81-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-423-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover, divulgar y promocionar la misión, visión, '
                . 'objetivos y valores de Pequiven, con el fin de consolidar la imagen e identidad '
                . 'corporativa, dirigido a potenciar un clima organizacional positivo.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-82-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-424-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover, divulgar y promocionar la misión, visión, '
                . 'objetivos y valores de Pequiven, con el fin de consolidar la imagen e identidad '
                . 'corporativa, dirigido a potenciar un clima organizacional positivo.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-83-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-425-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover, divulgar y promocionar la misión, visión, '
                . 'objetivos y valores de Pequiven, con el fin de consolidar la imagen e identidad '
                . 'corporativa, dirigido a potenciar un clima organizacional positivo.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-84-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-426-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //6.2.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Revisar y divulgar los procesos, políticas y normativas '
                . 'de Recursos Humanos, para mejorar la calidad de vida de los trabajadores y jubilados.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-79-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-427-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Revisar y divulgar los procesos, políticas y normativas '
                . 'de Recursos Humanos, para mejorar la calidad de vida de los trabajadores y jubilados.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-80-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-428-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Revisar y divulgar los procesos, políticas y normativas '
                . 'de Recursos Humanos, para mejorar la calidad de vida de los trabajadores y jubilados.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-81-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-429-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Revisar y divulgar los procesos, políticas y normativas '
                . 'de Recursos Humanos, para mejorar la calidad de vida de los trabajadores y jubilados.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-82-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-430-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Revisar y divulgar los procesos, políticas y normativas '
                . 'de Recursos Humanos, para mejorar la calidad de vida de los trabajadores y jubilados.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-83-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-431-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Revisar y divulgar los procesos, políticas y normativas '
                . 'de Recursos Humanos, para mejorar la calidad de vida de los trabajadores y jubilados.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-84-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-432-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //6.2.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar y aplicar estudios de compensación y valoración'
                . ' de cargos orientados al desarrollo, crecimiento y permanencia del trabajador en la'
                . ' Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-79-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-433-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar y aplicar estudios de compensación y valoración'
                . ' de cargos orientados al desarrollo, crecimiento y permanencia del trabajador en la'
                . ' Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-80-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-434-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
        
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar y aplicar estudios de compensación y valoración'
                . ' de cargos orientados al desarrollo, crecimiento y permanencia del trabajador en la'
                . ' Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-81-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-435-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar y aplicar estudios de compensación y valoración'
                . ' de cargos orientados al desarrollo, crecimiento y permanencia del trabajador en la'
                . ' Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-82-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-436-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar y aplicar estudios de compensación y valoración'
                . ' de cargos orientados al desarrollo, crecimiento y permanencia del trabajador en la'
                . ' Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-83-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-437-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar y aplicar estudios de compensación y valoración'
                . ' de cargos orientados al desarrollo, crecimiento y permanencia del trabajador en la'
                . ' Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-84-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-438-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //6.2.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar alianzas efectivas para fomentar el ahorro y '
                . 'otros mecanismos que mejoren la calidad de vida del trabajador, familiares '
                . 'y jubilados.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-79-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-439-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar alianzas efectivas para fomentar el ahorro y '
                . 'otros mecanismos que mejoren la calidad de vida del trabajador, familiares '
                . 'y jubilados.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-80-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-440-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar alianzas efectivas para fomentar el ahorro y '
                . 'otros mecanismos que mejoren la calidad de vida del trabajador, familiares '
                . 'y jubilados.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-81-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-441-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar alianzas efectivas para fomentar el ahorro y '
                . 'otros mecanismos que mejoren la calidad de vida del trabajador, familiares '
                . 'y jubilados.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-82-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-442-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar alianzas efectivas para fomentar el ahorro y '
                . 'otros mecanismos que mejoren la calidad de vida del trabajador, familiares '
                . 'y jubilados.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-83-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-443-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar alianzas efectivas para fomentar el ahorro y '
                . 'otros mecanismos que mejoren la calidad de vida del trabajador, familiares '
                . 'y jubilados.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-84-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-444-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //6.2.5
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar Acuerdos de Servicios con áreas conexas para '
                . 'optimización del tiempo de respuesta, mejorar ambiente de trabajo y entorno familiar '
                . 'de los trabajadores activos y jubilados.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-79-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-445-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar Acuerdos de Servicios con áreas conexas para '
                . 'optimización del tiempo de respuesta, mejorar ambiente de trabajo y entorno familiar '
                . 'de los trabajadores activos y jubilados.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-80-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-446-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar Acuerdos de Servicios con áreas conexas para '
                . 'optimización del tiempo de respuesta, mejorar ambiente de trabajo y entorno familiar '
                . 'de los trabajadores activos y jubilados.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-81-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-447-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar Acuerdos de Servicios con áreas conexas para '
                . 'optimización del tiempo de respuesta, mejorar ambiente de trabajo y entorno familiar '
                . 'de los trabajadores activos y jubilados.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-82-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-448-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar Acuerdos de Servicios con áreas conexas para '
                . 'optimización del tiempo de respuesta, mejorar ambiente de trabajo y entorno familiar '
                . 'de los trabajadores activos y jubilados.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-83-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-449-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar Acuerdos de Servicios con áreas conexas para '
                . 'optimización del tiempo de respuesta, mejorar ambiente de trabajo y entorno familiar '
                . 'de los trabajadores activos y jubilados.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-84-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-450-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //6.2.6
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover la participación activa y consciente de los '
                . 'trabajadores, familiares y jubilados en los procesos de transformación social.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-79-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-451-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover la participación activa y consciente de los '
                . 'trabajadores, familiares y jubilados en los procesos de transformación social.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-80-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-452-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover la participación activa y consciente de los '
                . 'trabajadores, familiares y jubilados en los procesos de transformación social.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-81-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-453-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover la participación activa y consciente de los '
                . 'trabajadores, familiares y jubilados en los procesos de transformación social.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-82-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-454-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover la participación activa y consciente de los '
                . 'trabajadores, familiares y jubilados en los procesos de transformación social.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-83-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-455-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover la participación activa y consciente de los '
                . 'trabajadores, familiares y jubilados en los procesos de transformación social.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-84-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-456-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //7.1.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar planes orientados a impulsar el Desarrollo '
                . 'Humano Integral de las comunidades, estableciendo metodologías de apoyo como '
                . 'elemento generador de acción colectiva.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-85-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-457-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar planes orientados a impulsar el Desarrollo '
                . 'Humano Integral de las comunidades, estableciendo metodologías de apoyo como '
                . 'elemento generador de acción colectiva.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-86-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-458-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar planes orientados a impulsar el Desarrollo '
                . 'Humano Integral de las comunidades, estableciendo metodologías de apoyo como '
                . 'elemento generador de acción colectiva.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-87-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-459-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar planes orientados a impulsar el Desarrollo '
                . 'Humano Integral de las comunidades, estableciendo metodologías de apoyo como '
                . 'elemento generador de acción colectiva.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-88-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-460-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar planes orientados a impulsar el Desarrollo '
                . 'Humano Integral de las comunidades, estableciendo metodologías de apoyo como '
                . 'elemento generador de acción colectiva.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-89-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-461-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar planes orientados a impulsar el Desarrollo '
                . 'Humano Integral de las comunidades, estableciendo metodologías de apoyo como '
                . 'elemento generador de acción colectiva.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-90-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-462-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //7.1.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover actividades sociales, culturales, deportivas, '
                . 'de salud, entre otras, que contribuyan al buen vivir y a una nueva cultura de paz.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-85-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-463-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover actividades sociales, culturales, deportivas, '
                . 'de salud, entre otras, que contribuyan al buen vivir y a una nueva cultura de paz.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-86-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-464-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover actividades sociales, culturales, deportivas, '
                . 'de salud, entre otras, que contribuyan al buen vivir y a una nueva cultura de paz.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-87-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-465-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover actividades sociales, culturales, deportivas, '
                . 'de salud, entre otras, que contribuyan al buen vivir y a una nueva cultura de paz.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-88-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-466-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover actividades sociales, culturales, deportivas, '
                . 'de salud, entre otras, que contribuyan al buen vivir y a una nueva cultura de paz.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-89-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-467-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover actividades sociales, culturales, deportivas, '
                . 'de salud, entre otras, que contribuyan al buen vivir y a una nueva cultura de paz.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-90-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-468-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //7.1.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos para la consolidación del proceso de'
                . ' formación socio-político.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-85-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-469-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos para la consolidación del proceso de'
                . ' formación socio-político.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-86-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-470-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos para la consolidación del proceso de'
                . ' formación socio-político.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-87-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-471-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos para la consolidación del proceso de'
                . ' formación socio-político.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-88-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-472-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos para la consolidación del proceso de'
                . ' formación socio-político.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-89-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-473-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos para la consolidación del proceso de'
                . ' formación socio-político.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-90-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-474-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //7.2.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Generar acciones que den impulso a las Misiones y Grandes'
                . ' Misiones Socialistas en especial la Gran Misión Vivienda Venezuela.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-91-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-475-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Generar acciones que den impulso a las Misiones y Grandes'
                . ' Misiones Socialistas en especial la Gran Misión Vivienda Venezuela.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-92-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-476-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Generar acciones que den impulso a las Misiones y Grandes'
                . ' Misiones Socialistas en especial la Gran Misión Vivienda Venezuela.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-93-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-477-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Generar acciones que den impulso a las Misiones y Grandes'
                . ' Misiones Socialistas en especial la Gran Misión Vivienda Venezuela.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-94-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-478-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Generar acciones que den impulso a las Misiones y Grandes'
                . ' Misiones Socialistas en especial la Gran Misión Vivienda Venezuela.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-95-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-479-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Generar acciones que den impulso a las Misiones y Grandes'
                . ' Misiones Socialistas en especial la Gran Misión Vivienda Venezuela.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-96-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-480-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //7.2.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar proyectos estructurantes viables en las comunidades'
                . ' ubicadas en el entorno de nuestras instalaciones, alineados a los planes '
                . 'gubernamentales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-91-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-481-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar proyectos estructurantes viables en las comunidades'
                . ' ubicadas en el entorno de nuestras instalaciones, alineados a los planes '
                . 'gubernamentales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-92-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-482-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar proyectos estructurantes viables en las comunidades'
                . ' ubicadas en el entorno de nuestras instalaciones, alineados a los planes '
                . 'gubernamentales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-93-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-483-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar proyectos estructurantes viables en las comunidades'
                . ' ubicadas en el entorno de nuestras instalaciones, alineados a los planes '
                . 'gubernamentales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-94-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-484-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar proyectos estructurantes viables en las comunidades'
                . ' ubicadas en el entorno de nuestras instalaciones, alineados a los planes '
                . 'gubernamentales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-95-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-485-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar proyectos estructurantes viables en las comunidades'
                . ' ubicadas en el entorno de nuestras instalaciones, alineados a los planes '
                . 'gubernamentales.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-96-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-486-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //7.2.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Activar redes institucionales y sociales co-responsables '
                . 'del desarrollo integral de las comunidades.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-91-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-487-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Activar redes institucionales y sociales co-responsables '
                . 'del desarrollo integral de las comunidades.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-92-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-488-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Activar redes institucionales y sociales co-responsables '
                . 'del desarrollo integral de las comunidades.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-93-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-489-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Activar redes institucionales y sociales co-responsables '
                . 'del desarrollo integral de las comunidades.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-94-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-490-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Activar redes institucionales y sociales co-responsables '
                . 'del desarrollo integral de las comunidades.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-95-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-491-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Activar redes institucionales y sociales co-responsables '
                . 'del desarrollo integral de las comunidades.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-96-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-492-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //7.2.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Contribuir con la formación técnica  y análisis '
                . 'sociopolítico en las comunidades vinculadas a los proyectos estructurantes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-91-01'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-493-01', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Contribuir con la formación técnica  y análisis '
                . 'sociopolítico en las comunidades vinculadas a los proyectos estructurantes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-92-02'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-494-02', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Contribuir con la formación técnica  y análisis '
                . 'sociopolítico en las comunidades vinculadas a los proyectos estructurantes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-93-03'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-495-03', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Contribuir con la formación técnica  y análisis '
                . 'sociopolítico en las comunidades vinculadas a los proyectos estructurantes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-94-04'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-496-04', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Contribuir con la formación técnica  y análisis '
                . 'sociopolítico en las comunidades vinculadas a los proyectos estructurantes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-95-05'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-497-05', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Contribuir con la formación técnica  y análisis '
                . 'sociopolítico en las comunidades vinculadas a los proyectos estructurantes.');
        $strategiesObjetive->setObjetive($this->getReference('OBJ-EST-96-06'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $strategiesObjetive->setEnabled(true);
        $this->addReference('EST-498-06', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $manager->flush();
    }
    
    public function getOrder(){
        return 11;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
