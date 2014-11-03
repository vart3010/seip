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
        $strategiesObjetive->setObjetive($this->getReference('OE-1.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('1.1.1.');
        $strategiesObjetive->setEnabled(true);        
        $this->addReference('ESTRATEGIA-1.1.1.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //1.1.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar acciones que permitan alcanzar una '
                . 'producción acorde con la capacidad de diseño de las instalaciones existentes.');
        $strategiesObjetive->setObjetive($this->getReference('OE-1.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('1.1.2.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-1.1.2.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //1.1.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar planes de mantenimiento de las '
                . 'instalaciones orientados hacia la filosofía de mantenimiento centrado '
                . 'en la confiabilidad.');
        $strategiesObjetive->setObjetive($this->getReference('OE-1.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('1.1.3.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-1.1.3.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //1.1.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Gestionar el suministro continuo, suficiente, '
                . 'oportuno y de calidad de las materias primas y servicios industriales; '
                . 'así como su uso eficiente en nuestras instalaciones');
        $strategiesObjetive->setObjetive($this->getReference('OE-1.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('1.1.4.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-1.1.4.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //1.1.5
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar planes de adecuación tecnológica en '
                . 'las instalaciones existentes.');
        $strategiesObjetive->setObjetive($this->getReference('OE-1.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('1.1.5.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-1.1.5.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //1.1.6
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar procesos de procura que garanticen '
                . 'la disponibilidad de repuestos, materiales e insumos requeridos para las '
                . 'operaciones.');
        $strategiesObjetive->setObjetive($this->getReference('OE-1.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('1.1.6.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-1.1.6.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //1.2.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar un Sistema de Gestión Estratégica con '
                . 'base en los Macroprocesos Medulares de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OE-1.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('1.2.1.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-1.2.1.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //1.2.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Mantener las certificaciones y continuar con '
                . 'los planes de normalización de los procesos de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OE-1.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('1.2.2.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-1.2.2.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //1.2.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos de mejores prácticas de la '
                . 'industria mediante el análisis de comparación con referentes nacionales '
                . 'e internacionales.');
        $strategiesObjetive->setObjetive($this->getReference('OE-1.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('1.2.3.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-1.2.3.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.1.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar el control efectivo de la ejecución '
                . 'presupuestaria planificada bajo la normativa legal vigente.');
        $strategiesObjetive->setObjetive($this->getReference('OE-2.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('2.1.1.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-2.1.1.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.1.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar los procesos de contratación y control '
                . 'de la ejecución de obras, prestación de servicios y adquisición de bienes.');
        $strategiesObjetive->setObjetive($this->getReference('OE-2.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('2.1.2.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-2.1.2.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.1.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar las políticas de créditos, cobranzas '
                . 'y pagos que permitan garantizar la liquidez de la empresa.');
        $strategiesObjetive->setObjetive($this->getReference('OE-2.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('2.1.3.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-2.1.3.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.1.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Evaluar el flujo de caja y la disponibilidad de '
                . 'fondos con el fin de garantizar su correcta distribución y uso.');
        $strategiesObjetive->setObjetive($this->getReference('OE-2.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('2.1.4.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-2.1.4.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.1.5
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar los niveles de inventario con el fin de '
                . 'mejorar el flujo de caja, reducir los costos y minimizar la carga fiscal '
                . 'de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OE-2.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('2.1.5.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-2.1.5.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.1.6
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Maximizar los beneficios de exención y exoneración '
                . 'de impuestos aplicables a la Corporación y filiales, dentro de los procesos '
                . 'productivos y comerciales de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OE-2.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('2.1.6.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-2.1.6.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.1.7
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer los procesos en materia de control previo,'
                . ' auditorias interna y externas, contabilidad y contraloría financiera y '
                . 'comunicación efectiva con todas las áreas que apoye a la toma de decisiones '
                . 'financiera de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OE-2.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('2.1.7.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-2.1.7.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.1.8
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Definir mecanismos para la obtención de '
                . 'financiamiento para los proyectos y sus respectivos desembolsos de forma '
                . 'oportuna.');
        $strategiesObjetive->setObjetive($this->getReference('OE-2.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('2.1.8.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-2.1.8.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.1.9
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar  la operatividad del Comité de Finanzas '
                . 'como órgano autónomo que apoye en las funciones de revisión, evaluación, '
                . 'validación y emisión de recomendaciones en operaciones de impacto financiero.');
        $strategiesObjetive->setObjetive($this->getReference('OE-2.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('2.1.9.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-2.1.9.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.1.10
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos para la oportuna cancelación '
                . 'del subsidio a los precios de venta de los productos petroquímicos.');
        $strategiesObjetive->setObjetive($this->getReference('OE-2.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('2.1.10.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-2.1.10.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.2.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar un sistema de actualización continua '
                . 'de las estructuras de costo de cada línea de producción.');
        $strategiesObjetive->setObjetive($this->getReference('OE-2.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('2.2.1.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-2.2.1.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.2.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar un sistema de planificación de costos '
                . 'para apalancar y fortalecer la gerencia estratégica de costos.');
        $strategiesObjetive->setObjetive($this->getReference('OE-2.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('2.2.2.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-2.2.2.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //2.2.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos para generar alertas y '
                . 'corregir desviaciones relacionadas a gastos y costos directos y/o '
                . 'indirectos de los procesos de producción y compras.');
        $strategiesObjetive->setObjetive($this->getReference('OE-2.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('2.2.3.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-2.2.3.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.1.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover una política de precios que permitan '
                . 'garantizar la sostenibilidad de cada línea de negocios en el marco de la '
                . 'Ley Orgánica de Precios Justos.');
        $strategiesObjetive->setObjetive($this->getReference('OE-3.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('3.1.1.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-3.1.1.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.1.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer en los trabajadores la cultura de la'
                . ' calidad y el enfoque al cliente.');
        $strategiesObjetive->setObjetive($this->getReference('OE-3.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('3.1.2.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-3.1.2.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.1.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar alianzas con proveedores que fortalezcan'
                . ' canales de distribución y mejore la atención del mercado.');
        $strategiesObjetive->setObjetive($this->getReference('OE-3.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('3.1.3.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-3.1.3.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.1.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Diseñar e implementar programas de promoción, '
                . 'servicio y asesoría técnico-comercial a clientes, que permitan el '
                . 'fortalecimiento de la imagen de nuestros productos y servicios.');
        $strategiesObjetive->setObjetive($this->getReference('OE-3.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('3.1.4.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-3.1.4.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.1.5
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover el desarrollo de infraestructura, para'
                . ' el manejo y distribución de productos químicos y petroquímicos, '
                . 'incentivando la inversión del Estado y sector privado en capacidades de'
                . ' almacenaje y transporte del sector.');
        $strategiesObjetive->setObjetive($this->getReference('OE-3.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('3.1.5.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-3.1.5.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.1.6
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Aplicación de políticas comerciales y de '
                . 'mercadeo que dinamicen las ventas y la atención del mercado.');
        $strategiesObjetive->setObjetive($this->getReference('OE-3.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('3.1.6.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-3.1.6.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.1.7
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Ejecutar planes de venta basados en un balance '
                . 'actualizado de los requerimientos de productos químicos y '
                . 'petroquímicos de los circulos productivos aguas abajo.');
        $strategiesObjetive->setObjetive($this->getReference('OE-3.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('3.1.7.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-3.1.7.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.2.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer condiciones de precios que garanticen'
                . ' la rentabilidad de la operación comercial.');
        $strategiesObjetive->setObjetive($this->getReference('OE-3.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('3.2.1.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-3.2.1.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.2.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer y mantener contratos anuales de '
                . 'suministro con clientes internacionales.');
        $strategiesObjetive->setObjetive($this->getReference('OE-3.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('3.2.2.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-3.2.2.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.2.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer en los trabajadores la cultura de la '
                . 'calidad y el enfoque al cliente.');
        $strategiesObjetive->setObjetive($this->getReference('OE-3.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('3.2.3.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-3.2.3.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.2.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Proveer servicios logísticos competitivos para '
                . 'la optimización de las redes de distribución.');
        $strategiesObjetive->setObjetive($this->getReference('OE-3.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('3.2.4.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-3.2.4.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.2.5
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover programas de servicio técnico de '
                . 'nuestros productos.');
        $strategiesObjetive->setObjetive($this->getReference('OE-3.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('3.2.5.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-3.2.5.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.2.6
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Incrementar la presencia en los espacios de '
                . 'cooperación comercial internacional en los que participa la Nación.');
        $strategiesObjetive->setObjetive($this->getReference('OE-3.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('3.2.6.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-3.2.6.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.2.7
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar programas anuales de acercamiento y '
                . 'comunicación con los clientes internacionales.');
        $strategiesObjetive->setObjetive($this->getReference('OE-3.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('3.2.7.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-3.2.7.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.2.8
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Atender los requerimientos que se originen de los '
                . 'acuerdos de cooperación comercial con países y sectores pertenecientes '
                . 'a alianzas estratégicas de la Nación.');
        $strategiesObjetive->setObjetive($this->getReference('OE-3.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('3.2.8.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-3.2.8.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.2.9
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Ejecutar planes de venta basados en la '
                . 'disponibilidad de productos petroquímicos para la exportación.');
        $strategiesObjetive->setObjetive($this->getReference('OE-3.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('3.2.9.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-3.2.9.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.3.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Identificar y evaluar mercados y negocios posibles.');
        $strategiesObjetive->setObjetive($this->getReference('OE-3.3.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('3.3.1.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-3.3.1.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.3.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar productos y servicios para mejorar '
                . 'la atención integral de los clientes.');
        $strategiesObjetive->setObjetive($this->getReference('OE-3.3.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('3.3.2.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-3.3.2.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.3.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer el análisis del entorno comercial e '
                . 'inteligencia de mercado.');
        $strategiesObjetive->setObjetive($this->getReference('OE-3.3.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('3.3.3.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-3.3.3.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //3.3.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Incentivar el desarrollo aguas abajo de las '
                . 'empresas relacionadas con la petroquímica (Filiales y Empresas Mixtas), '
                . 'que permitan alcanzar niveles de competitividad del sector transformador '
                . 'para colocar sus excedentes en el mercado internacional.');
        $strategiesObjetive->setObjetive($this->getReference('OE-3.3.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('3.3.4.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-3.3.4.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //4.1.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Elaborar y hacer seguimiento al Plan de Negocio '
                . 'Petroquímico.');
        $strategiesObjetive->setObjetive($this->getReference('OE-4.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('4.1.1.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-4.1.1.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //4.1.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar el cumplimiento de los planes de '
                . 'ejecución de proyectos desarrollados en el Plan Petroquímico Nacional.');
        $strategiesObjetive->setObjetive($this->getReference('OE-4.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('4.1.2.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-4.1.2.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //4.1.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover la definición de proyectos orientados al '
                . 'incremento de las capacidades de los productos actuales que satisfagan la '
                . 'demanda nacional con criterio de sostenibilidad económica.');
        $strategiesObjetive->setObjetive($this->getReference('OE-4.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('4.1.3.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-4.1.3.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //4.1.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Integrar las herramientas tecnológicas que soportan'
                . ' las operaciones e innovación petroquímica con los planes de crecimiento de '
                . 'la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OE-4.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('4.1.4.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-4.1.4.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //4.1.5
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar líneas de investigación e innovación petroquímica'
                . ' para el incremento y mejora de nuestras actuales áreas del negocio.');
        $strategiesObjetive->setObjetive($this->getReference('OE-4.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('4.1.5.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-4.1.5.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //4.1.6
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer alianzas, redes de investigación y desarrollo '
                . 'tecnológico con empresas, organismos e instituciones en el campo petroquímico a nivel '
                . 'nacional e internacional, para incrementar la producción en las líneas actuales del '
                . 'negocio.');
        $strategiesObjetive->setObjetive($this->getReference('OE-4.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('4.1.6.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-4.1.6.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //4.2.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar mecanismos de identificación de oportunidades '
                . 'del entorno y de potencialidades de proyectos conexos a la industria petroquímica.');
        $strategiesObjetive->setObjetive($this->getReference('OE-4.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('4.2.1.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-4.2.1.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //4.2.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Definir proyectos de diversificación acorde a las '
                . 'oportunidades de la Corporación y la factibilidad técnico-económica.');
        $strategiesObjetive->setObjetive($this->getReference('OE-4.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('4.2.2.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-4.2.2.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //4.2.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar líneas de investigación e innovación petroquímica'
                . ' para la creación de nuevos productos, servicios y aplicaciones tecnológicas.');
        $strategiesObjetive->setObjetive($this->getReference('OE-4.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('4.2.3.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-4.2.3.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //4.2.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer alianzas, redes de investigación y desarrollo '
                . 'tecnológico con empresas, organismos e instituciones en el campo petroquímico a nivel '
                . 'nacional e internacional, para la diversificación del negocio.');
        $strategiesObjetive->setObjetive($this->getReference('OE-4.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('4.2.4.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-4.2.4.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //4.2.5
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar capacidades científico, técnicas e '
                . 'institucionales para impulsar proyectos de investigación petroquímica, para la '
                . 'sustitución de importaciones, manejo adecuado de los recursos naturales que '
                . 'contribuyan con la soberanía y seguridad de la nación.');
        $strategiesObjetive->setObjetive($this->getReference('OE-4.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('4.2.5.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-4.2.5.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.1.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar en la Corporación el Sistema Integrado de '
                . 'Gestión de Riesgos.');
        $strategiesObjetive->setObjetive($this->getReference('OE-5.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('5.1.1.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-5.1.1.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.1.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover el uso de tecnologías, procesos, productos, '
                . 'materiales, equipos y sistemas, ambientalmente amigables y seguros.');
        $strategiesObjetive->setObjetive($this->getReference('OE-5.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('5.1.2.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-5.1.2.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.1.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Garantizar la prestación de los servicios de salud a los '
                . 'trabajadores,  trabajadoras, jubilados en las Clínicas Industriales y a los '
                . 'beneficiarios de los Planes de Salud.');
        $strategiesObjetive->setObjetive($this->getReference('OE-5.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('5.1.3.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-5.1.3.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
        //5.2.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar competencias en el personal en materia de SHA, '
                . 'con énfasis en la prevención y el manejo eficiente de los riesgos laborales, '
                . 'ambientales y a la salud.');
        $strategiesObjetive->setObjetive($this->getReference('OE-5.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('5.2.1.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-5.2.1.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.2.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer el control preventivo de todas las instalaciones'
                . ' y la seguridad de todo su personal y comunidades adyacentes.');
        $strategiesObjetive->setObjetive($this->getReference('OE-5.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('5.2.2.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-5.2.2.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.2.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos de validación de productos, materias '
                . 'primas e insumos, cuyas especificaciones, uso, transporte y disposición final como '
                . 'desechos no impacten la salud de las personas ni al ambiente.');
        $strategiesObjetive->setObjetive($this->getReference('OE-5.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('5.2.3.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-5.2.3.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.2.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Mantener comunicaciones efectivas con las comunidades del '
                . 'entorno, en relación a riesgos y respuesta ante emergencias.');
        $strategiesObjetive->setObjetive($this->getReference('OE-5.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('5.2.4.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-5.2.4.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.2.5
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos efectivos que permitan el registro, '
                . 'control y seguimiento de los incidentes.');
        $strategiesObjetive->setObjetive($this->getReference('OE-5.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('5.2.5.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-5.2.5.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.2.6
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar mecanismos para la Promoción, Prevención, y '
                . 'Rehabilitación en Salud Ocupacional e Integral de los trabajadores y trabajadoras.');
        $strategiesObjetive->setObjetive($this->getReference('OE-5.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('5.2.6.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-5.2.6.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.3.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Fortalecer los mecanismos de cooperación con las autoridades'
                . ' y entes reguladores del ambiente.');
        $strategiesObjetive->setObjetive($this->getReference('OE-5.3.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('5.3.1.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-5.3.1.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.3.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Definir planes para el uso racional de la energía, y en '
                . 'general, de los recursos naturales.');
        $strategiesObjetive->setObjetive($this->getReference('OE-5.3.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('5.3.2.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-5.3.2.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.3.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar evaluaciones y planes de manejo ambiental para '
                . 'prevenir, mitigar, controlar y compensar impactos ambientales.');
        $strategiesObjetive->setObjetive($this->getReference('OE-5.3.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('5.3.3.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-5.3.3.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //5.3.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar planes de conservación y repoblación forestal '
                . 'en las áreas de influencia de la Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OE-5.3.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('5.3.4.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-5.3.4.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //6.1.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Implementar un modelo de Plan de Carrera para los '
                . 'trabajadores de la Corporación; así como, un Plan de Sucesión en las posiciones claves,'
                . ' que permita desarrollar las competencias del supervisor como mentor, coach y/o '
                . 'facilitador de su equipo.');
        $strategiesObjetive->setObjetive($this->getReference('OE-6.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('6.1.1.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-6.1.1.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //6.1.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Optimizar los procesos de selección, formación y desarrollo '
                . 'del personal, adaptándolos al modelo de competencias.');
        $strategiesObjetive->setObjetive($this->getReference('OE-6.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('6.1.2.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-6.1.2.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //6.1.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Ampliar los canales de comunicación y acompañamiento de las'
                . ' líneas supervisorias como coadministrador de personal para una gestión de recursos'
                . ' humanos efectiva.');
        $strategiesObjetive->setObjetive($this->getReference('OE-6.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('6.1.3.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-6.1.3.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //6.1.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer alianzas con instituciones nacionales e '
                . 'internacionales para fortalecer el proceso de formación.');
        $strategiesObjetive->setObjetive($this->getReference('OE-6.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('6.1.4.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-6.1.4.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //6.2.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover, divulgar y promocionar la misión, visión, '
                . 'objetivos y valores de Pequiven, con el fin de consolidar la imagen e identidad '
                . 'corporativa, dirigido a potenciar un clima organizacional positivo.');
        $strategiesObjetive->setObjetive($this->getReference('OE-6.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('6.2.1.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-6.2.1.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //6.2.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Revisar y divulgar los procesos, políticas y normativas '
                . 'de Recursos Humanos, para mejorar la calidad de vida de los trabajadores y jubilados.');
        $strategiesObjetive->setObjetive($this->getReference('OE-6.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('6.2.2.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-6.2.2.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //6.2.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar y aplicar estudios de compensación y valoración'
                . ' de cargos orientados al desarrollo, crecimiento y permanencia del trabajador en la'
                . ' Corporación.');
        $strategiesObjetive->setObjetive($this->getReference('OE-6.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('6.2.3.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-6.2.3.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //6.2.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar alianzas efectivas para fomentar el ahorro y '
                . 'otros mecanismos que mejoren la calidad de vida del trabajador, familiares '
                . 'y jubilados.');
        $strategiesObjetive->setObjetive($this->getReference('OE-6.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('6.2.4.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-6.2.4.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //6.2.5
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar Acuerdos de Servicios con áreas conexas para '
                . 'optimización del tiempo de respuesta, mejorar ambiente de trabajo y entorno familiar '
                . 'de los trabajadores activos y jubilados.');
        $strategiesObjetive->setObjetive($this->getReference('OE-6.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('6.2.5.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-6.2.5.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //6.2.6
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover la participación activa y consciente de los '
                . 'trabajadores, familiares y jubilados en los procesos de transformación social.');
        $strategiesObjetive->setObjetive($this->getReference('OE-6.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('6.2.6.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-6.2.6.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //7.1.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Desarrollar planes orientados a impulsar el Desarrollo '
                . 'Humano Integral de las comunidades, estableciendo metodologías de apoyo como '
                . 'elemento generador de acción colectiva.');
        $strategiesObjetive->setObjetive($this->getReference('OE-7.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('7.1.1.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-7.1.1.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //7.1.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Promover actividades sociales, culturales, deportivas, '
                . 'de salud, entre otras, que contribuyan al buen vivir y a una nueva cultura de paz.');
        $strategiesObjetive->setObjetive($this->getReference('OE-7.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('7.1.2.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-7.1.2.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //7.1.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Establecer mecanismos para la consolidación del proceso de'
                . ' formación socio-político.');
        $strategiesObjetive->setObjetive($this->getReference('OE-7.1.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('7.1.3.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-7.1.3.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //7.2.1
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Generar acciones que den impulso a las Misiones y Grandes'
                . ' Misiones Socialistas en especial la Gran Misión Vivienda Venezuela.');
        $strategiesObjetive->setObjetive($this->getReference('OE-7.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('7.2.1.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-7.2.1.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //7.2.2
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Impulsar proyectos estructurantes viables en las comunidades'
                . ' ubicadas en el entorno de nuestras instalaciones, alineados a los planes '
                . 'gubernamentales.');
        $strategiesObjetive->setObjetive($this->getReference('OE-7.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('7.2.2.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-7.2.2.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //7.2.3
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Activar redes institucionales y sociales co-responsables '
                . 'del desarrollo integral de las comunidades.');
        $strategiesObjetive->setObjetive($this->getReference('OE-7.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('7.2.3.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-7.2.3.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        //7.2.4
        $strategiesObjetive = new StrategiesObjetive();
        $strategiesObjetive->setDescription('Contribuir con la formación técnica  y análisis '
                . 'sociopolítico en las comunidades vinculadas a los proyectos estructurantes.');
        $strategiesObjetive->setObjetive($this->getReference('OE-7.2.'));
        $strategiesObjetive->setUserCreatedAt($this->getReference('SUPER_ADMIN'));
        $strategiesObjetive->setRef('7.2.4.');
        $strategiesObjetive->setEnabled(true);
        $this->addReference('ESTRATEGIA-7.2.4.', $strategiesObjetive);
            $manager->persist($strategiesObjetive);
            
        $manager->flush();
    }
    
    public function getOrder(){
        return 15;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
