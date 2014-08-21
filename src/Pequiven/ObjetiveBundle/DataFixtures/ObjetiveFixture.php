<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\ObjetiveBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pequiven\ObjetiveBundle\Entity\Objetive;
use Pequiven\MasterBundle\Entity\LineStrategic;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
/**
 * Description of ObjetiveLevelFixture
 *
 * @author matias
 */
class ObjetiveFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){
        $line_data = new LineStrategic();
        $lineNameArray = $line_data->getLineNameArray();
        
        //1.1
        $objetive = new Objetive();
        $objetive->setDescription('Alcanzar el nivel de producción de las plantas existentes acorde a las '
                . 'capacidades instaladas y a los planes comerciales, garantizando la calidad de los '
                . 'productos obtenidos y la atención prioritaria a la demanda nacional.');
        $objetive->setComplejo($this->getReference('Complejo-01'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_EFICIENCIA_CALIDAD]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('1.1.');
        $this->addReference('OBJ-EST-01-01', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Alcanzar el nivel de producción de las plantas existentes acorde a las '
                . 'capacidades instaladas y a los planes comerciales, garantizando la calidad de los '
                . 'productos obtenidos y la atención prioritaria a la demanda nacional.');
        $objetive->setComplejo($this->getReference('Complejo-02'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_EFICIENCIA_CALIDAD]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('1.1.');
        $this->addReference('OBJ-EST-02-02', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Alcanzar el nivel de producción de las plantas existentes acorde a las '
                . 'capacidades instaladas y a los planes comerciales, garantizando la calidad de los '
                . 'productos obtenidos y la atención prioritaria a la demanda nacional.');
        $objetive->setComplejo($this->getReference('Complejo-03'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_EFICIENCIA_CALIDAD]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('1.1.');
        $this->addReference('OBJ-EST-03-03', $objetive);
            $manager->persist($objetive);
        
        $objetive = new Objetive();
        $objetive->setDescription('Alcanzar el nivel de producción de las plantas existentes acorde a las '
                . 'capacidades instaladas y a los planes comerciales, garantizando la calidad de los '
                . 'productos obtenidos y la atención prioritaria a la demanda nacional.');
        $objetive->setComplejo($this->getReference('Complejo-04'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_EFICIENCIA_CALIDAD]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('1.1.');
        $this->addReference('OBJ-EST-04-04', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Alcanzar el nivel de producción de las plantas existentes acorde a las '
                . 'capacidades instaladas y a los planes comerciales, garantizando la calidad de los '
                . 'productos obtenidos y la atención prioritaria a la demanda nacional.');
        $objetive->setComplejo($this->getReference('Complejo-05'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_EFICIENCIA_CALIDAD]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('1.1.');
        $this->addReference('OBJ-EST-05-05', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Alcanzar el nivel de producción de las plantas existentes acorde a las '
                . 'capacidades instaladas y a los planes comerciales, garantizando la calidad de los '
                . 'productos obtenidos y la atención prioritaria a la demanda nacional.');
        $objetive->setComplejo($this->getReference('Complejo-06'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_EFICIENCIA_CALIDAD]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('1.1.');
        $this->addReference('OBJ-EST-06-06', $objetive);
            $manager->persist($objetive);

        //1.2
        $objetive = new Objetive();
        $objetive->setDescription('Desarrollar y mantener el Sistema Integrado de Gestión de la Corporación, '
                . 'con el propósito de mejorar de forma continua la eficiencia y calidad de los procesos.');
        $objetive->setComplejo($this->getReference('Complejo-01'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_EFICIENCIA_CALIDAD]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('1.2.');
        $this->addReference('OBJ-EST-07-01', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Desarrollar y mantener el Sistema Integrado de Gestión de la Corporación, '
                . 'con el propósito de mejorar de forma continua la eficiencia y calidad de los procesos.');
        $objetive->setComplejo($this->getReference('Complejo-02'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_EFICIENCIA_CALIDAD]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('1.2.');
        $this->addReference('OBJ-EST-08-02', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Desarrollar y mantener el Sistema Integrado de Gestión de la Corporación, '
                . 'con el propósito de mejorar de forma continua la eficiencia y calidad de los procesos.');
        $objetive->setComplejo($this->getReference('Complejo-03'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_EFICIENCIA_CALIDAD]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('1.2.');
        $this->addReference('OBJ-EST-09-03', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Desarrollar y mantener el Sistema Integrado de Gestión de la Corporación, '
                . 'con el propósito de mejorar de forma continua la eficiencia y calidad de los procesos.');
        $objetive->setComplejo($this->getReference('Complejo-04'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_EFICIENCIA_CALIDAD]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('1.2.');
        $this->addReference('OBJ-EST-10-04', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Desarrollar y mantener el Sistema Integrado de Gestión de la Corporación, '
                . 'con el propósito de mejorar de forma continua la eficiencia y calidad de los procesos.');
        $objetive->setComplejo($this->getReference('Complejo-05'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_EFICIENCIA_CALIDAD]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('1.2.');
        $this->addReference('OBJ-EST-11-05', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Desarrollar y mantener el Sistema Integrado de Gestión de la Corporación, '
                . 'con el propósito de mejorar de forma continua la eficiencia y calidad de los procesos.');
        $objetive->setComplejo($this->getReference('Complejo-06'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_EFICIENCIA_CALIDAD]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('1.2.');
        $this->addReference('OBJ-EST-12-06', $objetive);
            $manager->persist($objetive);
            
        //2.1
        $objetive = new Objetive();
        $objetive->setDescription('Optimizar la gestión Financiera de la Corporación, orientada a '
                . 'lograr la independencia económica.');
        $objetive->setComplejo($this->getReference('Complejo-01'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SOST_FINANCIERA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('2.1.');
        $this->addReference('OBJ-EST-13-01', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Optimizar la gestión Financiera de la Corporación, orientada a '
                . 'lograr la independencia económica.');
        $objetive->setComplejo($this->getReference('Complejo-02'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SOST_FINANCIERA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('2.1.');
        $this->addReference('OBJ-EST-14-02', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Optimizar la gestión Financiera de la Corporación, orientada a '
                . 'lograr la independencia económica.');
        $objetive->setComplejo($this->getReference('Complejo-03'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SOST_FINANCIERA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('2.1.');
        $this->addReference('OBJ-EST-15-03', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Optimizar la gestión Financiera de la Corporación, orientada a '
                . 'lograr la independencia económica.');
        $objetive->setComplejo($this->getReference('Complejo-04'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SOST_FINANCIERA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('2.1.');
        $this->addReference('OBJ-EST-16-04', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Optimizar la gestión Financiera de la Corporación, orientada a '
                . 'lograr la independencia económica.');
        $objetive->setComplejo($this->getReference('Complejo-05'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SOST_FINANCIERA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('2.1.');
        $this->addReference('OBJ-EST-17-05', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Optimizar la gestión Financiera de la Corporación, orientada a '
                . 'lograr la independencia económica.');
        $objetive->setComplejo($this->getReference('Complejo-06'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SOST_FINANCIERA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('2.1.');
        $this->addReference('OBJ-EST-18-06', $objetive);
            $manager->persist($objetive);
            
        //2.2
        $objetive = new Objetive();
        $objetive->setDescription('Implementar un sistema de gestión estratégica de costos para '
                . 'garantizar la sostenibilidad del negocio.');
        $objetive->setComplejo($this->getReference('Complejo-01'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SOST_FINANCIERA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('2.2.');
        $this->addReference('OBJ-EST-19-01', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Implementar un sistema de gestión estratégica de costos para '
                . 'garantizar la sostenibilidad del negocio.');
        $objetive->setComplejo($this->getReference('Complejo-02'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SOST_FINANCIERA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('2.2.');
        $this->addReference('OBJ-EST-20-02', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Implementar un sistema de gestión estratégica de costos para '
                . 'garantizar la sostenibilidad del negocio.');
        $objetive->setComplejo($this->getReference('Complejo-03'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SOST_FINANCIERA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('2.2.');
        $this->addReference('OBJ-EST-21-03', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Implementar un sistema de gestión estratégica de costos para '
                . 'garantizar la sostenibilidad del negocio.');
        $objetive->setComplejo($this->getReference('Complejo-04'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SOST_FINANCIERA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('2.2.');
        $this->addReference('OBJ-EST-22-04', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Implementar un sistema de gestión estratégica de costos para '
                . 'garantizar la sostenibilidad del negocio.');
        $objetive->setComplejo($this->getReference('Complejo-05'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SOST_FINANCIERA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('2.2.');
        $this->addReference('OBJ-EST-23-05', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Implementar un sistema de gestión estratégica de costos para '
                . 'garantizar la sostenibilidad del negocio.');
        $objetive->setComplejo($this->getReference('Complejo-06'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SOST_FINANCIERA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('2.2.');
        $this->addReference('OBJ-EST-24-06', $objetive);
            $manager->persist($objetive);
            
        //3.1
        $objetive = new Objetive();
        $objetive->setDescription('Atender el mercado nacional de Productos Industriales, de Fertilizantes'
                . ' y de Olefinas y Plasticos, prioritamente con productos producidos por Pequiven, Filiales'
                . ' y Empresas Mixtas.');
        $objetive->setComplejo($this->getReference('Complejo-01'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_COMERCIALIZACION]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('3.1.');
        $this->addReference('OBJ-EST-25-01', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Atender el mercado nacional de Productos Industriales, de Fertilizantes'
                . ' y de Olefinas y Plasticos, prioritamente con productos producidos por Pequiven, Filiales'
                . ' y Empresas Mixtas.');
        $objetive->setComplejo($this->getReference('Complejo-02'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_COMERCIALIZACION]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('3.1.');
        $this->addReference('OBJ-EST-26-02', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Atender el mercado nacional de Productos Industriales, de Fertilizantes'
                . ' y de Olefinas y Plasticos, prioritamente con productos producidos por Pequiven, Filiales'
                . ' y Empresas Mixtas.');
        $objetive->setComplejo($this->getReference('Complejo-03'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_COMERCIALIZACION]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('3.1.');
        $this->addReference('OBJ-EST-27-03', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Atender el mercado nacional de Productos Industriales, de Fertilizantes'
                . ' y de Olefinas y Plasticos, prioritamente con productos producidos por Pequiven, Filiales'
                . ' y Empresas Mixtas.');
        $objetive->setComplejo($this->getReference('Complejo-04'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_COMERCIALIZACION]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('3.1.');
        $this->addReference('OBJ-EST-28-04', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Atender el mercado nacional de Productos Industriales, de Fertilizantes'
                . ' y de Olefinas y Plasticos, prioritamente con productos producidos por Pequiven, Filiales'
                . ' y Empresas Mixtas.');
        $objetive->setComplejo($this->getReference('Complejo-05'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_COMERCIALIZACION]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('3.1.');
        $this->addReference('OBJ-EST-29-05', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Atender el mercado nacional de Productos Industriales, de Fertilizantes'
                . ' y de Olefinas y Plasticos, prioritamente con productos producidos por Pequiven, Filiales'
                . ' y Empresas Mixtas.');
        $objetive->setComplejo($this->getReference('Complejo-06'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_COMERCIALIZACION]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('3.1.');
        $this->addReference('OBJ-EST-30-06', $objetive);
            $manager->persist($objetive);
            
        //3.2
        $objetive = new Objetive();
        $objetive->setDescription('Colocar en el mercado internacional la producción excedentaria de '
                . 'Productos Industriales, de Fertilizantes y de Olefinas y Plásticos producidos por '
                . 'Pequiven, Filiales y Empresas Mixtas.');
        $objetive->setComplejo($this->getReference('Complejo-01'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_COMERCIALIZACION]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('3.2.');
        $this->addReference('OBJ-EST-31-01', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Colocar en el mercado internacional la producción excedentaria de '
                . 'Productos Industriales, de Fertilizantes y de Olefinas y Plásticos producidos por '
                . 'Pequiven, Filiales y Empresas Mixtas.');
        $objetive->setComplejo($this->getReference('Complejo-02'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_COMERCIALIZACION]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('3.2.');
        $this->addReference('OBJ-EST-32-02', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Colocar en el mercado internacional la producción excedentaria de '
                . 'Productos Industriales, de Fertilizantes y de Olefinas y Plásticos producidos por '
                . 'Pequiven, Filiales y Empresas Mixtas.');
        $objetive->setComplejo($this->getReference('Complejo-03'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_COMERCIALIZACION]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('3.2.');
        $this->addReference('OBJ-EST-33-03', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Colocar en el mercado internacional la producción excedentaria de '
                . 'Productos Industriales, de Fertilizantes y de Olefinas y Plásticos producidos por '
                . 'Pequiven, Filiales y Empresas Mixtas.');
        $objetive->setComplejo($this->getReference('Complejo-04'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_COMERCIALIZACION]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('3.2.');
        $this->addReference('OBJ-EST-34-04', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Colocar en el mercado internacional la producción excedentaria de '
                . 'Productos Industriales, de Fertilizantes y de Olefinas y Plásticos producidos por '
                . 'Pequiven, Filiales y Empresas Mixtas.');
        $objetive->setComplejo($this->getReference('Complejo-05'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_COMERCIALIZACION]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('3.2.');
        $this->addReference('OBJ-EST-35-05', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Colocar en el mercado internacional la producción excedentaria de '
                . 'Productos Industriales, de Fertilizantes y de Olefinas y Plásticos producidos por '
                . 'Pequiven, Filiales y Empresas Mixtas.');
        $objetive->setComplejo($this->getReference('Complejo-06'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_COMERCIALIZACION]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('3.2.');
        $this->addReference('OBJ-EST-36-06', $objetive);
            $manager->persist($objetive);
            
        //3.3
        $objetive = new Objetive();
        $objetive->setDescription('Desarrollar nuevos negocios para la satisfacción de los clientes.');
        $objetive->setComplejo($this->getReference('Complejo-01'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_COMERCIALIZACION]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('3.3.');
        $this->addReference('OBJ-EST-37-01', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Desarrollar nuevos negocios para la satisfacción de los clientes.');
        $objetive->setComplejo($this->getReference('Complejo-02'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_COMERCIALIZACION]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('3.3.');
        $this->addReference('OBJ-EST-38-02', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Desarrollar nuevos negocios para la satisfacción de los clientes.');
        $objetive->setComplejo($this->getReference('Complejo-03'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_COMERCIALIZACION]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('3.3.');
        $this->addReference('OBJ-EST-39-03', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Desarrollar nuevos negocios para la satisfacción de los clientes.');
        $objetive->setComplejo($this->getReference('Complejo-04'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_COMERCIALIZACION]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('3.3.');
        $this->addReference('OBJ-EST-40-04', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Desarrollar nuevos negocios para la satisfacción de los clientes.');
        $objetive->setComplejo($this->getReference('Complejo-05'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_COMERCIALIZACION]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('3.3.');
        $this->addReference('OBJ-EST-41-05', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Desarrollar nuevos negocios para la satisfacción de los clientes.');
        $objetive->setComplejo($this->getReference('Complejo-06'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_COMERCIALIZACION]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('3.3.');
        $this->addReference('OBJ-EST-42-06', $objetive);
            $manager->persist($objetive);
            
        //4.1
        $objetive = new Objetive();
        $objetive->setDescription('Desarrollar proyectos petroquímicos orientados a incrementar la '
                . 'producción en la líneas actuales del negocio para satisfacer la demanda nacional y '
                . 'exportar los excedentes.');
        $objetive->setComplejo($this->getReference('Complejo-01'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_CRECIMIENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('4.1.');
        $this->addReference('OBJ-EST-43-01', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Desarrollar proyectos petroquímicos orientados a incrementar la '
                . 'producción en la líneas actuales del negocio para satisfacer la demanda nacional y '
                . 'exportar los excedentes.');
        $objetive->setComplejo($this->getReference('Complejo-02'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_CRECIMIENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('4.1.');
        $this->addReference('OBJ-EST-44-02', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Desarrollar proyectos petroquímicos orientados a incrementar la '
                . 'producción en la líneas actuales del negocio para satisfacer la demanda nacional y '
                . 'exportar los excedentes.');
        $objetive->setComplejo($this->getReference('Complejo-03'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_CRECIMIENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('4.1.');
        $this->addReference('OBJ-EST-45-03', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Desarrollar proyectos petroquímicos orientados a incrementar la '
                . 'producción en la líneas actuales del negocio para satisfacer la demanda nacional y '
                . 'exportar los excedentes.');
        $objetive->setComplejo($this->getReference('Complejo-04'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_CRECIMIENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('4.1.');
        $this->addReference('OBJ-EST-46-04', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Desarrollar proyectos petroquímicos orientados a incrementar la '
                . 'producción en la líneas actuales del negocio para satisfacer la demanda nacional y '
                . 'exportar los excedentes.');
        $objetive->setComplejo($this->getReference('Complejo-05'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_CRECIMIENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('4.1.');
        $this->addReference('OBJ-EST-47-05', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Desarrollar proyectos petroquímicos orientados a incrementar la '
                . 'producción en la líneas actuales del negocio para satisfacer la demanda nacional y '
                . 'exportar los excedentes.');
        $objetive->setComplejo($this->getReference('Complejo-06'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_CRECIMIENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('4.1.');
        $this->addReference('OBJ-EST-48-06', $objetive);
            $manager->persist($objetive);
            
        //4.2
        $objetive = new Objetive();
        $objetive->setDescription('Impulsar la diversificación del negocio petroquímico mediante las '
                . 'oportunidades y potencialidades de la Corporación aprovechando los recursos '
                . 'existentes en el país.');
        $objetive->setComplejo($this->getReference('Complejo-01'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_CRECIMIENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('4.2.');
        $this->addReference('OBJ-EST-49-01', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Impulsar la diversificación del negocio petroquímico mediante las '
                . 'oportunidades y potencialidades de la Corporación aprovechando los recursos '
                . 'existentes en el país.');
        $objetive->setComplejo($this->getReference('Complejo-02'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_CRECIMIENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('4.2.');
        $this->addReference('OBJ-EST-50-02', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Impulsar la diversificación del negocio petroquímico mediante las '
                . 'oportunidades y potencialidades de la Corporación aprovechando los recursos '
                . 'existentes en el país.');
        $objetive->setComplejo($this->getReference('Complejo-03'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_CRECIMIENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('4.2.');
        $this->addReference('OBJ-EST-51-03', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Impulsar la diversificación del negocio petroquímico mediante las '
                . 'oportunidades y potencialidades de la Corporación aprovechando los recursos '
                . 'existentes en el país.');
        $objetive->setComplejo($this->getReference('Complejo-04'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_CRECIMIENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('4.2.');
        $this->addReference('OBJ-EST-52-04', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Impulsar la diversificación del negocio petroquímico mediante las '
                . 'oportunidades y potencialidades de la Corporación aprovechando los recursos '
                . 'existentes en el país.');
        $objetive->setComplejo($this->getReference('Complejo-05'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_CRECIMIENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('4.2.');
        $this->addReference('OBJ-EST-53-05', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Impulsar la diversificación del negocio petroquímico mediante las '
                . 'oportunidades y potencialidades de la Corporación aprovechando los recursos '
                . 'existentes en el país.');
        $objetive->setComplejo($this->getReference('Complejo-06'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_CRECIMIENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('4.2.');
        $this->addReference('OBJ-EST-54-06', $objetive);
            $manager->persist($objetive);
            
        //5.1
        $objetive = new Objetive();
        $objetive->setDescription('Gestionar de forma sistemática y efectiva, los procesos necesarios '
                . 'para minimizar y controlar los riesgos en materia de Seguridad, Higiene, Ambiente '
                . 'y Salud en el Trabajo.');
        $objetive->setComplejo($this->getReference('Complejo-01'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SHA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('5.1.');
        $this->addReference('OBJ-EST-55-01', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Gestionar de forma sistemática y efectiva, los procesos necesarios '
                . 'para minimizar y controlar los riesgos en materia de Seguridad, Higiene, Ambiente '
                . 'y Salud en el Trabajo.');
        $objetive->setComplejo($this->getReference('Complejo-02'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SHA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('5.1.');
        $this->addReference('OBJ-EST-56-02', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Gestionar de forma sistemática y efectiva, los procesos necesarios '
                . 'para minimizar y controlar los riesgos en materia de Seguridad, Higiene, Ambiente '
                . 'y Salud en el Trabajo.');
        $objetive->setComplejo($this->getReference('Complejo-03'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SHA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('5.1.');
        $this->addReference('OBJ-EST-57-03', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Gestionar de forma sistemática y efectiva, los procesos necesarios '
                . 'para minimizar y controlar los riesgos en materia de Seguridad, Higiene, Ambiente '
                . 'y Salud en el Trabajo.');
        $objetive->setComplejo($this->getReference('Complejo-04'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SHA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('5.1.');
        $this->addReference('OBJ-EST-58-04', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Gestionar de forma sistemática y efectiva, los procesos necesarios '
                . 'para minimizar y controlar los riesgos en materia de Seguridad, Higiene, Ambiente '
                . 'y Salud en el Trabajo.');
        $objetive->setComplejo($this->getReference('Complejo-05'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SHA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('5.1.');
        $this->addReference('OBJ-EST-59-05', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Gestionar de forma sistemática y efectiva, los procesos necesarios '
                . 'para minimizar y controlar los riesgos en materia de Seguridad, Higiene, Ambiente '
                . 'y Salud en el Trabajo.');
        $objetive->setComplejo($this->getReference('Complejo-06'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SHA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('5.1.');
        $this->addReference('OBJ-EST-60-06', $objetive);
            $manager->persist($objetive);
            
        //5.2
        $objetive = new Objetive();
        $objetive->setDescription('Promover la cultura de prevención, las competencias de la seguridad '
                . 'ambiental, el manejo eficiente de los riesgos, la salud laboral y el control preventivo '
                . 'en la Corporación así como en las comunidades adyacentes a nuestras instalaciones.');
        $objetive->setComplejo($this->getReference('Complejo-01'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SHA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('5.2.');
        $this->addReference('OBJ-EST-61-01', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Promover la cultura de prevención, las competencias de la seguridad '
                . 'ambiental, el manejo eficiente de los riesgos, la salud laboral y el control preventivo '
                . 'en la Corporación así como en las comunidades adyacentes a nuestras instalaciones.');
        $objetive->setComplejo($this->getReference('Complejo-02'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SHA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('5.2.');
        $this->addReference('OBJ-EST-62-02', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Promover la cultura de prevención, las competencias de la seguridad '
                . 'ambiental, el manejo eficiente de los riesgos, la salud laboral y el control preventivo '
                . 'en la Corporación así como en las comunidades adyacentes a nuestras instalaciones.');
        $objetive->setComplejo($this->getReference('Complejo-03'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SHA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('5.2.');
        $this->addReference('OBJ-EST-63-03', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Promover la cultura de prevención, las competencias de la seguridad '
                . 'ambiental, el manejo eficiente de los riesgos, la salud laboral y el control preventivo '
                . 'en la Corporación así como en las comunidades adyacentes a nuestras instalaciones.');
        $objetive->setComplejo($this->getReference('Complejo-04'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SHA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('5.2.');
        $this->addReference('OBJ-EST-64-04', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Promover la cultura de prevención, las competencias de la seguridad '
                . 'ambiental, el manejo eficiente de los riesgos, la salud laboral y el control preventivo '
                . 'en la Corporación así como en las comunidades adyacentes a nuestras instalaciones.');
        $objetive->setComplejo($this->getReference('Complejo-05'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SHA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('5.2.');
        $this->addReference('OBJ-EST-65-05', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Promover la cultura de prevención, las competencias de la seguridad '
                . 'ambiental, el manejo eficiente de los riesgos, la salud laboral y el control preventivo '
                . 'en la Corporación así como en las comunidades adyacentes a nuestras instalaciones.');
        $objetive->setComplejo($this->getReference('Complejo-06'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SHA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('5.2.');
        $this->addReference('OBJ-EST-66-06', $objetive);
            $manager->persist($objetive);
            
        //5.3
        $objetive = new Objetive();
        $objetive->setDescription('Contribuir al desarrollo nacional mediante la conservación del '
                . 'ambiente y los recursos naturales.');
        $objetive->setComplejo($this->getReference('Complejo-01'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SHA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('5.3.');
        $this->addReference('OBJ-EST-67-01', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Contribuir al desarrollo nacional mediante la conservación del '
                . 'ambiente y los recursos naturales.');
        $objetive->setComplejo($this->getReference('Complejo-02'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SHA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('5.3.');
        $this->addReference('OBJ-EST-68-02', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Contribuir al desarrollo nacional mediante la conservación del '
                . 'ambiente y los recursos naturales.');
        $objetive->setComplejo($this->getReference('Complejo-03'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SHA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('5.3.');
        $this->addReference('OBJ-EST-69-03', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Contribuir al desarrollo nacional mediante la conservación del '
                . 'ambiente y los recursos naturales.');
        $objetive->setComplejo($this->getReference('Complejo-04'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SHA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('5.3.');
        $this->addReference('OBJ-EST-70-04', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Contribuir al desarrollo nacional mediante la conservación del '
                . 'ambiente y los recursos naturales.');
        $objetive->setComplejo($this->getReference('Complejo-05'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SHA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('5.3.');
        $this->addReference('OBJ-EST-71-05', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Contribuir al desarrollo nacional mediante la conservación del '
                . 'ambiente y los recursos naturales.');
        $objetive->setComplejo($this->getReference('Complejo-06'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SHA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('5.3.');
        $this->addReference('OBJ-EST-72-06', $objetive);
            $manager->persist($objetive);
            
        //6.1
        $objetive = new Objetive();
        $objetive->setDescription('Proveer el talento humano calificado y desarrollar sus competencias '
                . 'laborales alineados a los requerimientos de la Corporación.');
        $objetive->setComplejo($this->getReference('Complejo-01'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_GESTION_TALENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('6.1.');
        $this->addReference('OBJ-EST-73-01', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Proveer el talento humano calificado y desarrollar sus competencias '
                . 'laborales alineados a los requerimientos de la Corporación.');
        $objetive->setComplejo($this->getReference('Complejo-02'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_GESTION_TALENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('6.1.');
        $this->addReference('OBJ-EST-74-02', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Proveer el talento humano calificado y desarrollar sus competencias '
                . 'laborales alineados a los requerimientos de la Corporación.');
        $objetive->setComplejo($this->getReference('Complejo-03'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_GESTION_TALENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('6.1.');
        $this->addReference('OBJ-EST-75-03', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Proveer el talento humano calificado y desarrollar sus competencias '
                . 'laborales alineados a los requerimientos de la Corporación.');
        $objetive->setComplejo($this->getReference('Complejo-04'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_GESTION_TALENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('6.1.');
        $this->addReference('OBJ-EST-76-04', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Proveer el talento humano calificado y desarrollar sus competencias '
                . 'laborales alineados a los requerimientos de la Corporación.');
        $objetive->setComplejo($this->getReference('Complejo-05'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_GESTION_TALENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('6.1.');
        $this->addReference('OBJ-EST-77-05', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Proveer el talento humano calificado y desarrollar sus competencias '
                . 'laborales alineados a los requerimientos de la Corporación.');
        $objetive->setComplejo($this->getReference('Complejo-06'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_GESTION_TALENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('6.1.');
        $this->addReference('OBJ-EST-78-06', $objetive);
            $manager->persist($objetive);
            
        //6.2
        $objetive = new Objetive();
        $objetive->setDescription('Promover una Cultura Organizacional que permita mejorar la calidad '
                . 'de vida de los trabajadores, familiares y jubilados de la Corporación.');
        $objetive->setComplejo($this->getReference('Complejo-01'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_GESTION_TALENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('6.2.');
        $this->addReference('OBJ-EST-79-01', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Promover una Cultura Organizacional que permita mejorar la calidad '
                . 'de vida de los trabajadores, familiares y jubilados de la Corporación.');
        $objetive->setComplejo($this->getReference('Complejo-02'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_GESTION_TALENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('6.2.');
        $this->addReference('OBJ-EST-80-02', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Promover una Cultura Organizacional que permita mejorar la calidad '
                . 'de vida de los trabajadores, familiares y jubilados de la Corporación.');
        $objetive->setComplejo($this->getReference('Complejo-03'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_GESTION_TALENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('6.2.');
        $this->addReference('OBJ-EST-81-03', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Promover una Cultura Organizacional que permita mejorar la calidad '
                . 'de vida de los trabajadores, familiares y jubilados de la Corporación.');
        $objetive->setComplejo($this->getReference('Complejo-04'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_GESTION_TALENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('6.2.');
        $this->addReference('OBJ-EST-82-04', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Promover una Cultura Organizacional que permita mejorar la calidad '
                . 'de vida de los trabajadores, familiares y jubilados de la Corporación.');
        $objetive->setComplejo($this->getReference('Complejo-05'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_GESTION_TALENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('6.2.');
        $this->addReference('OBJ-EST-83-05', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Promover una Cultura Organizacional que permita mejorar la calidad '
                . 'de vida de los trabajadores, familiares y jubilados de la Corporación.');
        $objetive->setComplejo($this->getReference('Complejo-06'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_GESTION_TALENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('6.2.');
        $this->addReference('OBJ-EST-84-06', $objetive);
            $manager->persist($objetive);
            
        //7.1
        $objetive = new Objetive();
        $objetive->setDescription('Impulsar un sistema de relaciones sociales de desarrollo colectivo '
                . 'sustentado en los valores del saber y el trabajo, en pro de la satisfacción plena '
                . 'de las necesidades humanas de nuestro pueblo.');
        $objetive->setComplejo($this->getReference('Complejo-01'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_RESP_SOCIAL]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('7.1.');
        $this->addReference('OBJ-EST-85-01', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Impulsar un sistema de relaciones sociales de desarrollo colectivo '
                . 'sustentado en los valores del saber y el trabajo, en pro de la satisfacción plena '
                . 'de las necesidades humanas de nuestro pueblo.');
        $objetive->setComplejo($this->getReference('Complejo-02'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_RESP_SOCIAL]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('7.1.');
        $this->addReference('OBJ-EST-86-02', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Impulsar un sistema de relaciones sociales de desarrollo colectivo '
                . 'sustentado en los valores del saber y el trabajo, en pro de la satisfacción plena '
                . 'de las necesidades humanas de nuestro pueblo.');
        $objetive->setComplejo($this->getReference('Complejo-03'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_RESP_SOCIAL]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('7.1.');
        $this->addReference('OBJ-EST-87-03', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Impulsar un sistema de relaciones sociales de desarrollo colectivo '
                . 'sustentado en los valores del saber y el trabajo, en pro de la satisfacción plena '
                . 'de las necesidades humanas de nuestro pueblo.');
        $objetive->setComplejo($this->getReference('Complejo-04'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_RESP_SOCIAL]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('7.1.');
        $this->addReference('OBJ-EST-88-04', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Impulsar un sistema de relaciones sociales de desarrollo colectivo '
                . 'sustentado en los valores del saber y el trabajo, en pro de la satisfacción plena '
                . 'de las necesidades humanas de nuestro pueblo.');
        $objetive->setComplejo($this->getReference('Complejo-05'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_RESP_SOCIAL]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('7.1.');
        $this->addReference('OBJ-EST-89-05', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Impulsar un sistema de relaciones sociales de desarrollo colectivo '
                . 'sustentado en los valores del saber y el trabajo, en pro de la satisfacción plena '
                . 'de las necesidades humanas de nuestro pueblo.');
        $objetive->setComplejo($this->getReference('Complejo-06'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_RESP_SOCIAL]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('7.1.');
        $this->addReference('OBJ-EST-90-06', $objetive);
            $manager->persist($objetive);
            
        //7.2
        $objetive = new Objetive();
        $objetive->setDescription('Impulsar la organización de las comunidades y el desarrollo de '
                . 'proyectos estructurantes en el entorno de nuestras instalaciones.');
        $objetive->setComplejo($this->getReference('Complejo-01'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_RESP_SOCIAL]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('7.2.');
        $this->addReference('OBJ-EST-91-01', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Impulsar la organización de las comunidades y el desarrollo de '
                . 'proyectos estructurantes en el entorno de nuestras instalaciones.');
        $objetive->setComplejo($this->getReference('Complejo-02'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_RESP_SOCIAL]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('7.2.');
        $this->addReference('OBJ-EST-92-02', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Impulsar la organización de las comunidades y el desarrollo de '
                . 'proyectos estructurantes en el entorno de nuestras instalaciones.');
        $objetive->setComplejo($this->getReference('Complejo-03'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_RESP_SOCIAL]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('7.2.');
        $this->addReference('OBJ-EST-93-03', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Impulsar la organización de las comunidades y el desarrollo de '
                . 'proyectos estructurantes en el entorno de nuestras instalaciones.');
        $objetive->setComplejo($this->getReference('Complejo-04'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_RESP_SOCIAL]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('7.2.');
        $this->addReference('OBJ-EST-94-04', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Impulsar la organización de las comunidades y el desarrollo de '
                . 'proyectos estructurantes en el entorno de nuestras instalaciones.');
        $objetive->setComplejo($this->getReference('Complejo-05'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_RESP_SOCIAL]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('7.2.');
        $this->addReference('OBJ-EST-95-05', $objetive);
            $manager->persist($objetive);
            
        $objetive = new Objetive();
        $objetive->setDescription('Impulsar la organización de las comunidades y el desarrollo de '
                . 'proyectos estructurantes en el entorno de nuestras instalaciones.');
        $objetive->setComplejo($this->getReference('Complejo-06'));
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->setLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_RESP_SOCIAL]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('directive-10019742'));
        $objetive->setRef('7.2.');
        $this->addReference('OBJ-EST-96-06', $objetive);
            $manager->persist($objetive);
          
        $manager->flush();
    }
    
    public function getOrder(){
        return 10;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
