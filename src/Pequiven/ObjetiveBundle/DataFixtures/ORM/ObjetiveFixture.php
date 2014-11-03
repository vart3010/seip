<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\ObjetiveBundle\DataFixtures\ORM;

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
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->addLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_EFICIENCIA_CALIDAD]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $objetive->setRef('1.1.');
        $objetive->addIndicator($this->getReference('IE-1.1.1.'));
        $objetive->addIndicator($this->getReference('IE-1.1.2.'));
        $objetive->addIndicator($this->getReference('IE-1.1.3.'));
        $objetive->addIndicator($this->getReference('IE-1.1.4.'));
        $objetive->addIndicator($this->getReference('IE-1.1.5.'));
        $this->addReference('OE-1.1.', $objetive);
            $manager->persist($objetive);

        //1.2
        $objetive = new Objetive();
        $objetive->setDescription('Desarrollar y mantener el Sistema Integrado de Gestión de la Corporación, '
                . 'con el propósito de mejorar de forma continua la eficiencia y calidad de los procesos.');
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->addLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_EFICIENCIA_CALIDAD]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $objetive->setRef('1.2.');
        $objetive->addIndicator($this->getReference('IE-1.2.1.'));
        $objetive->addIndicator($this->getReference('IE-1.2.2.'));
        $this->addReference('OE-1.2.', $objetive);
            $manager->persist($objetive);
            
        //2.1
        $objetive = new Objetive();
        $objetive->setDescription('Optimizar la gestión Financiera de la Corporación, orientada a '
                . 'lograr la independencia económica.');
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->addLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SOST_FINANCIERA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $objetive->setRef('2.1.');
        $objetive->addIndicator($this->getReference('IE-2.1.1.'));
        $objetive->addIndicator($this->getReference('IE-2.1.2.'));
        $objetive->addIndicator($this->getReference('IE-2.1.3.'));
        $objetive->addIndicator($this->getReference('IE-2.1.4.'));
        $objetive->addIndicator($this->getReference('IE-2.1.5.'));
        $this->addReference('OE-2.1.', $objetive);
            $manager->persist($objetive);
            
        //2.2
        $objetive = new Objetive();
        $objetive->setDescription('Implementar un sistema de gestión estratégica de costos para '
                . 'garantizar la sostenibilidad del negocio.');
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->addLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SOST_FINANCIERA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $objetive->setRef('2.2.');
        $objetive->addIndicator($this->getReference('IE-2.2.1.'));
        $objetive->addIndicator($this->getReference('IE-2.2.2.'));
        $objetive->addIndicator($this->getReference('IE-2.2.3.'));
        $this->addReference('OE-2.2.', $objetive);
            $manager->persist($objetive);
            
        //3.1
        $objetive = new Objetive();
        $objetive->setDescription('Atender el mercado nacional de Productos Industriales, de Fertilizantes'
                . ' y de Olefinas y Plasticos, prioritamente con productos producidos por Pequiven, Filiales'
                . ' y Empresas Mixtas.');
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->addLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_COMERCIALIZACION]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $objetive->setRef('3.1.');
        $objetive->addIndicator($this->getReference('IE-3.1.1.'));
        $objetive->addIndicator($this->getReference('IE-3.1.2.'));
        $objetive->addIndicator($this->getReference('IE-3.1.3.'));
        $this->addReference('OE-3.1.', $objetive);
            $manager->persist($objetive);
            
        //3.2
        $objetive = new Objetive();
        $objetive->setDescription('Colocar en el mercado internacional la producción excedentaria de '
                . 'Productos Industriales, de Fertilizantes y de Olefinas y Plásticos producidos por '
                . 'Pequiven, Filiales y Empresas Mixtas.');
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->addLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_COMERCIALIZACION]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $objetive->setRef('3.2.');
        $objetive->addIndicator($this->getReference('IE-3.2.1.'));
        $this->addReference('OE-3.2.', $objetive);
            $manager->persist($objetive);
            
        //3.3
        $objetive = new Objetive();
        $objetive->setDescription('Desarrollar nuevos negocios para la satisfacción de los clientes.');
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->addLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_COMERCIALIZACION]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $objetive->setRef('3.3.');
        $objetive->addIndicator($this->getReference('IE-3.3.1.'));
        $this->addReference('OE-3.3.', $objetive);
            $manager->persist($objetive);
            
        //4.1
        $objetive = new Objetive();
        $objetive->setDescription('Desarrollar proyectos petroquímicos orientados a incrementar la '
                . 'producción en las líneas actuales del negocio para satisfacer la demanda nacional y '
                . 'exportar los excedentes.');
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->addLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_CRECIMIENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $objetive->setRef('4.1.');
        $objetive->addIndicator($this->getReference('IE-4.1.1.'));
        $objetive->addIndicator($this->getReference('IE-4.1.2.'));
        $objetive->addIndicator($this->getReference('IE-4.1.3.'));
        $this->addReference('OE-4.1.', $objetive);
            $manager->persist($objetive);
            
        //4.2
        $objetive = new Objetive();
        $objetive->setDescription('Impulsar la diversificación del negocio petroquímico mediante las '
                . 'oportunidades y potencialidades de la Corporación aprovechando los recursos '
                . 'existentes en el país.');
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->addLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_CRECIMIENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $objetive->setRef('4.2.');
        $objetive->addIndicator($this->getReference('IE-4.2.1.'));
        $this->addReference('OE-4.2.', $objetive);
            $manager->persist($objetive);
            
        //5.1
        $objetive = new Objetive();
        $objetive->setDescription('Gestionar de forma sistemática y efectiva, los procesos necesarios '
                . 'para minimizar y controlar los riesgos en materia de Seguridad, Higiene, Ambiente '
                . 'y Salud en el Trabajo.');
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->addLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SHA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $objetive->setRef('5.1.');
        $objetive->addIndicator($this->getReference('IE-5.1.1.'));
        $this->addReference('OE-5.1.', $objetive);
            $manager->persist($objetive);
            
        //5.2
        $objetive = new Objetive();
        $objetive->setDescription('Promover la cultura de prevención, las competencias de la seguridad '
                . 'ambiental, el manejo eficiente de los riesgos, la salud laboral y el control preventivo '
                . 'en la Corporación así como en las comunidades adyacentes a nuestras instalaciones.');
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->addLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SHA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $objetive->setRef('5.2.');
        $objetive->addIndicator($this->getReference('IE-5.2.1.'));
        $objetive->addIndicator($this->getReference('IE-5.2.2.'));
        $objetive->addIndicator($this->getReference('IE-5.2.3.'));
        $objetive->addIndicator($this->getReference('IE-5.2.4.'));
        $objetive->addIndicator($this->getReference('IE-5.2.5.'));
        $this->addReference('OE-5.2.', $objetive);
            $manager->persist($objetive);
            
        //5.3
        $objetive = new Objetive();
        $objetive->setDescription('Contribuir al desarrollo nacional mediante la conservación del '
                . 'ambiente y los recursos naturales.');
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->addLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_SHA]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $objetive->setRef('5.3.');
        $objetive->addIndicator($this->getReference('IE-5.3.1.'));
        $this->addReference('OE-5.3.', $objetive);
            $manager->persist($objetive);
            
        //6.1
        $objetive = new Objetive();
        $objetive->setDescription('Proveer el talento humano calificado y desarrollar sus competencias '
                . 'laborales alineadas a los requerimientos de la Corporación.');
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->addLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_GESTION_TALENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $objetive->setRef('6.1.');
        $objetive->addIndicator($this->getReference('IE-6.1.1.'));
        $objetive->addIndicator($this->getReference('IE-6.1.2.'));
        $this->addReference('OE-6.1.', $objetive);
            $manager->persist($objetive);
            
        //6.2
        $objetive = new Objetive();
        $objetive->setDescription('Promover una Cultura Organizacional que permita mejorar la calidad '
                . 'de vida de los trabajadores, familiares y jubilados de la Corporación.');
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->addLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_GESTION_TALENTO]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $objetive->setRef('6.2.');
        $objetive->addIndicator($this->getReference('IE-6.2.1.'));
        $this->addReference('OE-6.2.', $objetive);
            $manager->persist($objetive);
            
        //7.1
        $objetive = new Objetive();
        $objetive->setDescription('Impulsar un sistema de relaciones sociales de desarrollo colectivo '
                . 'sustentado en los valores del saber y el trabajo, en pro de la satisfacción plena '
                . 'de las necesidades humanas de nuestro pueblo.');        
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->addLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_RESP_SOCIAL]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $objetive->setRef('7.1.');
        $objetive->addIndicator($this->getReference('IE-7.1.1.'));
        $this->addReference('OE-7.1.', $objetive);
            $manager->persist($objetive);

        //7.2
        $objetive = new Objetive();
        $objetive->setDescription('Impulsar la organización de las comunidades y el desarrollo de '
                . 'proyectos estructurantes en el entorno de nuestras instalaciones.');        
        $objetive->setObjetiveLevel($this->getReference('OBJETIVO_ESTRATEGICO'));
        $objetive->addLineStrategic($this->getReference($lineNameArray[LineStrategic::LINE_RESP_SOCIAL]));
        $objetive->setEnabled(true);
        $objetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $objetive->setRef('7.2.');
        $objetive->addIndicator($this->getReference('IE-7.2.1.'));
        $this->addReference('OE-7.2.', $objetive);
            $manager->persist($objetive);
            
        $manager->flush();
    }
    
    public function getOrder(){
        return 14;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
