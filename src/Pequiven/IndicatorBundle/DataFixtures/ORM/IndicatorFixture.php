<?php
namespace Pequiven\IndicatorBundle\DataFixtures\ORM;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\IndicatorBundle\Entity\IndicatorLevel;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
/**
 * Description of IndicatorFixture
 *
 * @author matias
 */
class IndicatorFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){
        
        $IndicatorLevel = new IndicatorLevel();
        $lineLevelArray = $IndicatorLevel->getLevelNameArray();

        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-01'));
        $indicator->setDescription('Ejecución de la Producción');
        $indicator->setIndicatorLevel($this->getReference($lineLevelArray[IndicatorLevel::LEVEL_ESTRATEGICO]));
        $indicator->setRef('IE-1.1.1.');
        $indicator->setEnabled(true);
        $this->addReference('IE-1.1.1.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();        
        $indicator->setFormula($this->getReference('Formula-02'));
        $indicator->setDescription('Consumo de Materia Prima');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-1.1.2.');
        $indicator->setEnabled(true);
        $this->addReference('IE-1.1.2.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-03'));
        $indicator->setDescription('Consumo de Servicios Industriales');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-1.1.3.');
        $indicator->setEnabled(true);
        $this->addReference('IE-1.1.3.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setDescription('Producción No Realizada (PNR)');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-1.1.4.');
        $indicator->setEnabled(true);
        $this->addReference('IE-1.1.4.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-05'));
        $indicator->setDescription('Alicuota');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-1.1.5.');
        $indicator->setEnabled(true);
        $this->addReference('IE-1.1.5.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-06'));
        $indicator->setDescription('Normalización de los Procesos');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-1.2.1.');
        $indicator->setEnabled(true);
        $this->addReference('IE-1.2.1.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-07'));
        $indicator->setDescription('Mantenimiento de los Sistemas de Gestión');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-1.2.2.');
        $indicator->setEnabled(true);
        $this->addReference('IE-1.2.2.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-08'));
        $indicator->setDescription('Cuentas por Cobrar');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-2.1.1.');
        $indicator->setEnabled(true);
        $this->addReference('IE-2.1.1.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-09'));
        $indicator->setDescription('Cuentas por Pagar');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-2.1.2.');
        $indicator->setEnabled(true);
        $this->addReference('IE-2.1.2.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-10'));
        $indicator->setDescription('Ingresos por Ventas');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-2.1.3.');
        $indicator->setEnabled(true);
        $this->addReference('IE-2.1.3.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setDescription('Flujo de Caja');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-2.1.4.');
        $indicator->setEnabled(true);
        $this->addReference('IE-2.1.4.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-12'));
        $indicator->setDescription('Ejecución Presupuestaria');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-2.1.5.');
        $indicator->setEnabled(true);
        $this->addReference('IE-2.1.5.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-13'));
        $indicator->setDescription('Costo del Producto');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-2.2.1.');
        $indicator->setEnabled(true);
        $this->addReference('IE-2.2.1.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-14'));
        $indicator->setDescription('Egreso por Compras para Abastecimiento');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-2.2.2.');
        $indicator->setEnabled(true);
        $this->addReference('IE-2.2.2.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-15'));
        $indicator->setDescription('Rentabilidad');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-2.2.3.');
        $indicator->setEnabled(true);
        $this->addReference('IE-2.2.3.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-16'));
        $indicator->setDescription('Volumétrico de Compras (Para Abastecimiento)');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-3.1.1.');
        $indicator->setEnabled(true);
        $this->addReference('IE-3.1.1.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setDescription('Inventario de Producto Final');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-3.1.2.');
        $indicator->setEnabled(true);
        $this->addReference('IE-3.1.2.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-18'));
        $indicator->setDescription('Volumétrico de Ventas Nacionales');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-3.1.3.');
        $indicator->setEnabled(true);
        $this->addReference('IE-3.1.3.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-19'));
        $indicator->setDescription('Volumétrico de Ventas Internacionales (No Incluye Trading)');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-3.2.1.');
        $indicator->setEnabled(true);
        $this->addReference('IE-3.2.1.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-20'));
        $indicator->setDescription('Desarrollo de Nuevos Negocios');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-3.3.1.');
        $indicator->setEnabled(true);
        $this->addReference('IE-3.3.1.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-21'));
        $indicator->setDescription('Avance Físico de los Proyectos de Inversión Capital');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-4.1.1.');
        $indicator->setEnabled(true);
        $this->addReference('IE-4.1.1.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-21'));
        $indicator->setDescription('Avance Financiero de los Proyectos de Inversión Capital');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-4.1.2.');
        $indicator->setEnabled(true);
        $this->addReference('IE-4.1.2.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-23'));
        $indicator->setDescription('Financiamiento de los Proyectos de Inversión Capital');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-4.1.3.');
        $indicator->setEnabled(true);
        $this->addReference('IE-4.1.3.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-20'));
        $indicator->setDescription('Diversificación del Negocio');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-4.2.1.');
        $indicator->setEnabled(true);
        $this->addReference('IE-4.2.1.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-25'));
        $indicator->setDescription('Cierre de Recomendaciones de la Reaseguradora');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-5.1.1.');
        $indicator->setEnabled(true);
        $this->addReference('IE-5.1.1.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-26'));
        $indicator->setDescription('Accidentalidad (Frecuencia Bruta)');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-5.2.1.');
        $indicator->setEnabled(true);
        $this->addReference('IE-5.2.1.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-27'));
        $indicator->setDescription('Accidentalidad (Frecuencia Neta)');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-5.2.2.');
        $indicator->setEnabled(true);
        $this->addReference('IE-5.2.2.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-28'));
        $indicator->setDescription('Accidentalidad (Severidad)');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-5.2.3.');
        $indicator->setEnabled(true);
        $this->addReference('IE-5.2.3.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-29'));
        $indicator->setDescription('Morbilidad (Incidencia)');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-5.2.4.');
        $indicator->setEnabled(true);
        $this->addReference('IE-5.2.4.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-30'));
        $indicator->setDescription('Morbilidad (Prevalencia)');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-5.2.5.');
        $indicator->setEnabled(true);
        $this->addReference('IE-5.2.5.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-31'));
        $indicator->setDescription('Eventos Ambientales');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-5.3.1.');
        $indicator->setEnabled(true);
        $this->addReference('IE-5.3.1.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-32'));
        $indicator->setDescription('Fuerza Labor');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-6.1.1.');
        $indicator->setEnabled(true);
        $this->addReference('IE-6.1.1.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-33'));
        $indicator->setDescription('Eficacia de la Capacitación');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-6.1.2.');
        $indicator->setEnabled(true);
        $this->addReference('IE-6.1.2.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-34'));
        $indicator->setDescription('Promoción de la Cultura Organizacional');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-6.2.1.');
        $indicator->setEnabled(true);
        $this->addReference('IE-6.2.1.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-35'));
        $indicator->setDescription('Índice de Desarrollo Humano');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-7.1.1.');
        $indicator->setEnabled(true);
        $this->addReference('IE-7.1.1.', $indicator);
            $manager->persist($indicator);
            
        $indicator = new Indicator();
        $indicator->setFormula($this->getReference('Formula-36'));
        $indicator->setDescription('Inversión en Infraestructura y Desarollo Social');
        $indicator->setIndicatorLevel($this->getReference('INDICADOR_ESTRATEGICO'));
        $indicator->setRef('IE-7.2.1.');
        $indicator->setEnabled(true);
        $this->addReference('IE-7.2.1.', $indicator);
            $manager->persist($indicator);
            
        $manager->flush();
    }
    
    public function getOrder(){
        return 13;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}