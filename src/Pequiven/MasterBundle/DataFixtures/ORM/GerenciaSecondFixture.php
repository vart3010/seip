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
use Pequiven\MasterBundle\Entity\Gerencia;
use Pequiven\MasterBundle\Entity\GerenciaSecond;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
/**
 * Description of GerenciaSecondFixture
 *
 * @author matias
 */
class GerenciaSecondFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){
        
        $complejo_data = new Complejo();
        $complejoNameArray = $complejo_data->getRefNameArray();
        
        $gerencia_data = new Gerencia();
        $refGerenciaNameArray = $gerencia_data->getRefNameArray();
        
        $gerenciaSecond_data = new GerenciaSecond();
        $refNameArray = $gerenciaSecond_data->getRefNameArray();
        
        
        //Morón-Gerencia General
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Producción');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPM]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PRODUCCION_CPM]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PRODUCCION_CPM], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Mantenimiento');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPM]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_MANTENIMIENTO_CPM]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_MANTENIMIENTO_CPM], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Servicios Generales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPM]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_SERV_GENERALES_CPM]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_SERV_GENERALES_CPM], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
//        $gerenciaSecond = new GerenciaSecond();
//        $gerenciaSecond->setDescription('Gerencia SHA CPM');
//        $gerenciaSecond->setEnabled(1);
//        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
//        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPM]));
//        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_SHA_CPM]);
//        $gerenciaSecond->setModular(true);
//        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_MODULAR_SHA_CPM], $gerenciaSecond);
//            $manager->persist($gerenciaSecond);
            
//        $gerenciaSecond = new GerenciaSecond();
//        $gerenciaSecond->setDescription('Coordinación de Desarrollo Social CPM');
//        $gerenciaSecond->setEnabled(1);
//        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
//        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPM]));
//        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_DESARROLLO_SOCIAL_CPM]);
//        $gerenciaSecond->setModular(true);
//        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_MODULAR_DESARROLLO_SOCIAL_CPM], $gerenciaSecond);
//            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia Técnica');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPM]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_TECNICA_CPM]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_TECNICA_CPM], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Suministro');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPM]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_SUMINISTRO_CPM]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_SUMINISTRO_CPM], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Materiales/Bariven');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPM]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_MATERIALES_BARIVEN_CPM]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_MATERIALES_BARIVEN_CPM], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Proyectos Troncal III Vía Perimetral');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPM]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PROYECTOS_TRONCAL_III_VIA_PERIMETRAL]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PROYECTOS_TRONCAL_III_VIA_PERIMETRAL], $gerenciaSecond);
            $manager->persist($gerenciaSecond);

        //Morón-UNFER
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Planificación Comercial');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_UNFER]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACION_COMERCIAL_UNFER]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACION_COMERCIAL_UNFER], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Abastecimiento de Fertilizantes');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_UNFER]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_ABASTECIMIENTO_FERTILIZANTES_UNFER]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_ABASTECIMIENTO_FERTILIZANTES_UNFER], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Finanzas UNFER');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_UNFER]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_FINANZAS_UNFER]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_FINANZAS_UNFER], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        //Morón-UNPI
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Planificación Gestión y Control');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_UNPI]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACION_GESTION_Y_CONTROL_UNPI]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACION_GESTION_Y_CONTROL_UNPI], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Ventas Nacionales y Mercadeo');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_UNPI]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_VENTAS_NACIONALES_Y_MERCADEO_UNPI_CPJAA]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_VENTAS_NACIONALES_Y_MERCADEO_UNPI_CPJAA], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia Planta Distr. Terminal Borburata');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_UNPI]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PLANTA_DIST_TERMINAL_BORBURATA_UNPI_CPJAA]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PLANTA_DIST_TERMINAL_BORBURATA_UNPI_CPJAA], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
        
        //Morón-Proyectos Morón
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia Proyecto Fosfatado Morón');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PROYECTOS_MORON]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PROYECTO_FOSFATADO_MORON]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PROYECTO_FOSFATADO_MORON], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia Arranque Fosfatados Nuevas Plantas');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PROYECTOS_MORON]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_ARRANQUE_FOSFATADOS_NUEVAS_PLANTAS]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_ARRANQUE_FOSFATADOS_NUEVAS_PLANTAS], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia Proyecto Nitrogenado Morón');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PROYECTOS_MORON]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PROYECTO_NITROGENADO_MORON]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PROYECTO_NITROGENADO_MORON], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia Arranque Nitrogenados Nuevas Plantas');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PROYECTOS_MORON]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_ARRANQUE_NITROGENADOS_NUEVAS_PLANTAS]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_ARRANQUE_NITROGENADOS_NUEVAS_PLANTAS], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia Infraestructura y Servicios');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PROYECTOS_MORON]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_INFRAESTRUCTURA_Y_SERVICIOS]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_INFRAESTRUCTURA_Y_SERVICIOS], $gerenciaSecond);
            $manager->persist($gerenciaSecond);

        //Morón-Logística Comercial
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia Operac. Portuarias Ensacado y Mezclado');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_LOGISTICA_COMERCIAL]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_OPERAC_PROTUARIAS_ENSACADO_Y_MEZCLADO]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_OPERAC_PROTUARIAS_ENSACADO_Y_MEZCLADO], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Distribución y Transporte');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_LOGISTICA_COMERCIAL]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_DISTRIBUCION_Y_TRANSPORTE]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_DISTRIBUCION_Y_TRANSPORTE], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        //Morón-IPSL/Comercio Exterior
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia Comercial de Fertilizantes');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_IPSL_COMERCIO_EXTERIOR]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_COMERCIAL_FERTILIZANTES]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_COMERCIAL_FERTILIZANTES], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia Comercial');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_IPSL_COMERCIO_EXTERIOR]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_COMERCIAL]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_COMERCIAL], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia Comercial de Productos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_IPSL_COMERCIO_EXTERIOR]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_COMERCIAL_PRODUCTOS]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_COMERCIAL_PRODUCTOS], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Administración y Finanzas');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_IPSL_COMERCIO_EXTERIOR]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_ADMINISTRACION_Y_FINANZAS]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_ADMINISTRACION_Y_FINANZAS], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Logística');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_IPSL_COMERCIO_EXTERIOR]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_LOGISTICA]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_LOGISTICA], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gcia. Planificación e Inteligencia de Merc.');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_IPSL_COMERCIO_EXTERIOR]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACION_E_INTELIGENCIA_DE_MERC]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACION_E_INTELIGENCIA_DE_MERC], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        //AMC-Gerencia General
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Producción');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPAMC]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PRODUCCION_CPAMC]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PRODUCCION_CPAMC], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Mantenimiento');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPAMC]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_MANTENIMIENTO_CPAMC]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_MANTENIMIENTO_CPAMC], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia Técnica');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPAMC]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_TECNICA_CPAMC]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_TECNICA_CPAMC], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Servicios Generales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPAMC]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_SERV_GENERALES_CPAMC]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_SERV_GENERALES_CPAMC], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Suministro');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPAMC]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_SUMINISTRO_CPAMC]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_SUMINISTRO_CPAMC], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
//        $gerenciaSecond = new GerenciaSecond();
//        $gerenciaSecond->setDescription('Gerencia SHA CPAMC');
//        $gerenciaSecond->setEnabled(1);
//        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
//        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPAMC]));
//        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_SHA_CPAMC]);
//        $gerenciaSecond->setModular(true);
//        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_MODULAR_SHA_CPAMC], $gerenciaSecond);
//            $manager->persist($gerenciaSecond);
            
//        $gerenciaSecond = new GerenciaSecond();
//        $gerenciaSecond->setDescription('Gerencia Regional Desarrollo Integral Comunitario CPAMC');
//        $gerenciaSecond->setEnabled(1);
//        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
//        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPAMC]));
//        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_REGIONAL_DESARROLLO_INTEGRAL_COMUNITARIO_CPAMC]);
//        $gerenciaSecond->setModular(true);
//        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_MODULAR_REGIONAL_DESARROLLO_INTEGRAL_COMUNITARIO_CPAMC], $gerenciaSecond);
//            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Proyectos Operacionales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPAMC]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PROYECTOS_OPERACIONALES]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PROYECTOS_OPERACIONALES], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Materiales (PDVSA)');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPAMC]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_MATERIALES_CPAMC]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_MATERIALES_CPAMC], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        //AMC-UNOP
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Mercadeo y Ventas');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_UNOP]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_MERCADEO_Y_VENTAS_UNOP]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_MERCADEO_Y_VENTAS_UNOP], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Planificación');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_UNOP]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACION_UNOP]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACION_UNOP], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        //JAA-Gerencia General
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Producción');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPJAA]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PRODUCCION_CPJAA]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PRODUCCION_CPJAA], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Matenimiento');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPJAA]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_MANTENIMIENTO_CPJAA]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_MANTENIMIENTO_CPJAA], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Servicios Generales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPJAA]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_SERV_GENERALES_CPJAA]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_SERV_GENERALES_CPJAA], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia Técnica y de Proyectos Operacionales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPJAA]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_TECNICA_Y_PROYECTOS_OPERACIONALES_CPJAA]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_TECNICA_Y_PROYECTOS_OPERACIONALES_CPJAA], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Materiales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPJAA]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_MATERIALES_CPJAA]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_MATERIALES_CPJAA], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
//        $gerenciaSecond = new GerenciaSecond();
//        $gerenciaSecond->setDescription('Gerencia SHA CPJAA');
//        $gerenciaSecond->setEnabled(1);
//        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
//        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPJAA]));
//        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_SHA_CPJAA]);
//        $gerenciaSecond->setModular(true);
//        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_MODULAR_SHA_CPJAA], $gerenciaSecond);
//            $manager->persist($gerenciaSecond);
            
//        $gerenciaSecond = new GerenciaSecond();
//        $gerenciaSecond->setDescription('Gerencia Regional Desarrollo Integral Comunitario CPJAA');
//        $gerenciaSecond->setEnabled(1);
//        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
//        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPJAA]));
//        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_REGIONAL_DESARROLLO_INTEGRAL_COMUNITARIO_CPJAA]);
//        $gerenciaSecond->setModular(true);
//        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_MODULAR_REGIONAL_DESARROLLO_INTEGRAL_COMUNITARIO_CPJAA], $gerenciaSecond);
//            $manager->persist($gerenciaSecond);
                
        //Navay-Gerencia General
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia Desarrollo Mina Navay');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_PRONAVAY]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_NAVAY]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_DESARROLLO_MINA_NAVAY]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_DESARROLLO_MINA_NAVAY], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia Plantas y Serv. Industriales Navay');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_PRONAVAY]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_NAVAY]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PLANTAS_Y_SERV_INDUSTRIALES_NAVAY]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PLANTAS_Y_SERV_INDUSTRIALES_NAVAY], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia Infraestructura Navay');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_PRONAVAY]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_NAVAY]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_INFRAESTRUCTURA_NAVAY]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_INFRAESTRUCTURA_NAVAY], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Relaciones con el Entorno');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_PRONAVAY]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_NAVAY]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_RELACIONES_CON_ENTORNO_NAVAY]);
        $gerenciaSecond->setModular(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_RELACIONES_CON_ENTORNO_NAVAY], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        //ZIV-Estimación de Costos
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Estimación de Costos CPM');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_ESTIMACION_COSTOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_ESTIMACION_COSTOS_CPM]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_ESTIMACION_COSTOS_CPM], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Estimación de Costos CPAMC');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_ESTIMACION_COSTOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_ESTIMACION_COSTOS_CPAMC]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_ESTIMACION_COSTOS_CPAMC], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Estimación de Costos CPJAA');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_ESTIMACION_COSTOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_ESTIMACION_COSTOS_CPJAA]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_ESTIMACION_COSTOS_CPJAA], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Estimación de Costos OP');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_ESTIMACION_COSTOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_ESTIMACION_COSTOS_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_ESTIMACION_COSTOS_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
                    
        //ZIV-Planificación Estratégica y Nvos. Desarrollos
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Planificación');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACIÓN_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACIÓN_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Control Estadístico e Información');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_CONTROL_ESTADISTICO_E_INFORMACION_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_CONTROL_ESTADISTICO_E_INFORMACION_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Análisis y Evaluación Económica');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_ANALISIS_Y_EVALUACION_ECONOMICA_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_ANALISIS_Y_EVALUACION_ECONOMICA_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Ingeniería');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_INGENIERIA_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_INGENIERIA_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
        
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Coordinación Morón');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_COORDINACION_MORON]);
        $this->addReference($refNameArray[GerenciaSecond::REF_COORDINACION_MORON], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Coordinación AMC');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_COORDINACION_AMC]);
        $this->addReference($refNameArray[GerenciaSecond::REF_COORDINACION_AMC], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Coordinación JAA');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_COORDINACION_JAA]);
        $this->addReference($refNameArray[GerenciaSecond::REF_COORDINACION_JAA], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        //ZIV-Seg. Ctrol. Financiero/Admvo. Proyectos
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Planificación y Control de Gestión');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_SEG_CTROL_FINANCIERO_ADMVO_PROY]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACION_CONTROL_DE_GESTION]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACION_CONTROL_DE_GESTION], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Control de Gestión Administrativa');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_SEG_CTROL_FINANCIERO_ADMVO_PROY]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_SERVICIOS_FINANCIEROS_PROYECTOS]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_SERVICIOS_FINANCIEROS_PROYECTOS], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Servicios Financieros Proyectos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_SEG_CTROL_FINANCIERO_ADMVO_PROY]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_EVAL_Y_CTROL_FINANC_ADMIN_PROYECTOS]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_EVAL_Y_CTROL_FINANC_ADMIN_PROYECTOS], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        //ZIV-Proyectos Internacionales
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Relaciones Institucionales y Logística');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PROYECTOS_INTERNACIONALES]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_RELAC_INSTITUCIONALES_Y_LOGISTICA]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_RELAC_INSTITUCIONALES_Y_LOGISTICA], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Planificación y Nuevos Desarrollos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PROYECTOS_INTERNACIONALES]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACION_Y_NUEVOS_DESARROLLOS]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACION_Y_NUEVOS_DESARROLLOS], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Ingeniería Proyectos Internacionales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PROYECTOS_INTERNACIONALES]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_INGENIERIA_PROYECTOS_INTERNACIONALES]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_INGENIERIA_PROYECTOS_INTERNACIONALES], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        //ZIV-Proyecto Terminal Marítimo
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de QA/QC');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PROYECTO_TERMINAL_MARITIMO_CPM]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_QA_QC]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_QA_QC], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Ingeniería y Construcción');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PROYECTO_TERMINAL_MARITIMO_CPM]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_INGENIERIA_Y_CONSTRUCCION]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_INGENIERIA_Y_CONSTRUCCION], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Arranque');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PROYECTO_TERMINAL_MARITIMO_CPM]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_ARRANQUE]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_ARRANQUE], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        //ZIV-Recursos Humanos
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Planificación y Control de Gestión Recursos Humanos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_RECURSOS_HUMANOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACION_Y_CTROL_GESTION_RRHH_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACION_Y_CTROL_GESTION_RRHH_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Servicios Organizacionales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_RECURSOS_HUMANOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_SERVICIOS_ORGANIZACIONALES_RRHH_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_SERVICIOS_ORGANIZACIONALES_RRHH_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Planes y Beneficios');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_RECURSOS_HUMANOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PLANES_Y_BENEFICIOS_RRHH_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PLANES_Y_BENEFICIOS_RRHH_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Relaciones Laborales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_RECURSOS_HUMANOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_RELACIONES_LABORALES_RRHH_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_RELACIONES_LABORALES_RRHH_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Calidad de Vida');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_RECURSOS_HUMANOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_CALIDAD_DE_VIDA_RRHH_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_CALIDAD_DE_VIDA_RRHH_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia CAPET');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_RECURSOS_HUMANOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_CAPET_RRHH_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_CAPET_RRHH_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Recursos Humanos Sede Principal');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_RECURSOS_HUMANOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_RRHH_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_RRHH_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Recursos Humanos CPM');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_RECURSOS_HUMANOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_RRHH_CPM]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_RRHH_CPM], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Recursos Humanos CPAMC');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_RECURSOS_HUMANOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_RRHH_CPAMC]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_RRHH_CPAMC], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Recursos Humanos CPJAA');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_RECURSOS_HUMANOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_RRHH_CPJAA]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_RRHH_CPJAA], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        //ZIV-Auditoria Interna
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Auditoría de Olefinas y Plásticos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_AUDITORIA_INTERNA]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_AUDITORIA_OLEFINAS_Y_PLASTICOS_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_AUDITORIA_OLEFINAS_Y_PLASTICOS_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Auditoría de Fertilizantes');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_AUDITORIA_INTERNA]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_AUDITORIA_FERTILIZANTES_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_AUDITORIA_FERTILIZANTES_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Auditoría de Prod. Ind. Y Proc. Corp.');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_AUDITORIA_INTERNA]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_AUDITORIA_PROC_IND_Y_PROC_CORP_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_AUDITORIA_PROC_IND_Y_PROC_CORP_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Auditoría de Proyectos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_AUDITORIA_INTERNA]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_AUDITORIA_PROYECTOS_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_AUDITORIA_PROYECTOS_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Determinación de Responsabilidades');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_AUDITORIA_INTERNA]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_DETERMINACION_DE_RESPONSABILIDADES_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_DETERMINACION_DE_RESPONSABILIDADES_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        //ZIV-Consultoria Jurídica y Rpte. Judicial
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Asuntos Legales Proyectos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_CONSULTORIA_JURIDICA_Y_RPTE_JUDICIAL]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_ASUNTOS_LEGALES_PROYECTOS_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_ASUNTOS_LEGALES_PROYECTOS_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Asuntos Legales Nacionales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_CONSULTORIA_JURIDICA_Y_RPTE_JUDICIAL]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_ASUNTOS_LEGALES_NACIONALES_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_ASUNTOS_LEGALES_NACIONALES_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Asuntos Legales Internacionales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_CONSULTORIA_JURIDICA_Y_RPTE_JUDICIAL]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_ASUNTOS_LEGALES_INTERNACIONALES_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_ASUNTOS_LEGALES_INTERNACIONALES_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Litigios y Reclamos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_CONSULTORIA_JURIDICA_Y_RPTE_JUDICIAL]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_LITIGIOS_Y_RECLAMOS_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_LITIGIOS_Y_RECLAMOS_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Asuntos Legales CPM');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_CONSULTORIA_JURIDICA_Y_RPTE_JUDICIAL]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_ASUNTOS_LEGALES_CPM]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_ASUNTOS_LEGALES_CPM], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Asuntos Legales CPAMC');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_CONSULTORIA_JURIDICA_Y_RPTE_JUDICIAL]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_ASUNTOS_LEGALES_CPAMC]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_ASUNTOS_LEGALES_CPAMC], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Asuntos Legales CPJAA');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_CONSULTORIA_JURIDICA_Y_RPTE_JUDICIAL]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_ASUNTOS_LEGALES_CPJAA]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_ASUNTOS_LEGALES_CPJAA], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        //ZIV-Contrataciones
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Procura');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_CONTRATACIONES]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PROCURA_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PROCURA_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Contrataciones Sede Valencia');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_CONTRATACIONES]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_CONTRATACIONES_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_CONTRATACIONES_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        //ZIV-Finanzas
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Servicios Financieros');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_FINANZAS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_SERVICIOS_FINANCIEROS_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_SERVICIOS_FINANCIEROS_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Presupuesto y Costos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_FINANZAS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PRESUPUESTOS_Y_COSTOS_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PRESUPUESTOS_Y_COSTOS_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia Tributario');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_FINANZAS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_TRIBUTARIO_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_TRIBUTARIO_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Tesorería');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_FINANZAS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_TESORERIA_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_TESORERIA_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Contraloría Financiera');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_FINANZAS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_CONTRALORIA_FINANCIERA]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_CONTRALORIA_FINANCIERA], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Riesgos y Seguros');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_FINANZAS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_RIESGOS_Y_SEGUROS]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_RIESGOS_Y_SEGUROS], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Finanzas CPM');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_FINANZAS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_FINANZAS_CPM]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_FINANZAS_CPM], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Finanzas CPAMC');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_FINANZAS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_FINANZAS_CPAMC]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_FINANZAS_CPAMC], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Finanzas CPJAA');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_FINANZAS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_FINANZAS_CPJAA]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_FINANZAS_CPJAA], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        //ZIV-AIT
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Infraestructura de Telecomunicaciones');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_AUTOMATIZACION_INFORMATICA_Y_TELECOMUNICACIONES]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_INFRAESTRUCTURA_DE_TELECOMUNICACIONES_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_INFRAESTRUCTURA_DE_TELECOMUNICACIONES_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Sistemas y Aplicaciones');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_AUTOMATIZACION_INFORMATICA_Y_TELECOMUNICACIONES]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_SISTEMAS_Y_APLICACIONES_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_SISTEMAS_Y_APLICACIONES_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Planificación y Control de Gestión');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_AUTOMATIZACION_INFORMATICA_Y_TELECOMUNICACIONES]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACION_CONTROL_DE_GESTION_AIT_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACION_CONTROL_DE_GESTION_AIT_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Infraestructura y Operaciones');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_AUTOMATIZACION_INFORMATICA_Y_TELECOMUNICACIONES]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_INFRAESTRUCTURA_Y_OPERACIONES_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_INFRAESTRUCTURA_Y_OPERACIONES_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia A.I.T· Centro');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_AUTOMATIZACION_INFORMATICA_Y_TELECOMUNICACIONES]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_AIT_CPM]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_AIT_CPM], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia A.I.T. Occidente');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_AUTOMATIZACION_INFORMATICA_Y_TELECOMUNICACIONES]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_AIT_CPAMC]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_AIT_CPAMC], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia A.I.T. Oriente');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_AUTOMATIZACION_INFORMATICA_Y_TELECOMUNICACIONES]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_AIT_CPJAA]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_AIT_CPJAA], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        //ZIV-PCP
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Investigaciones');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PREVENCION_Y_CONTROL_PERDIDAS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_INVESTIGACIONES_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_INVESTIGACIONES_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Operaciones');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PREVENCION_Y_CONTROL_PERDIDAS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_OPERACIONES_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_OPERACIONES_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Empresas Mixtas y Nvos. Proyectos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PREVENCION_Y_CONTROL_PERDIDAS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_EMPRESAS_MIXTAS_Y_NVOS_PROYECTOS_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_EMPRESAS_MIXTAS_Y_NVOS_PROYECTOS_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Protección Empresarial');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PREVENCION_Y_CONTROL_PERDIDAS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PROTECCION_EMPRESARIAL_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PROTECCION_EMPRESARIAL_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Adm. y Cont. de Gestión');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PREVENCION_Y_CONTROL_PERDIDAS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_ADM_Y_CONTROL_DE_GESTION_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_ADM_Y_CONTROL_DE_GESTION_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Prevención');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PREVENCION_Y_CONTROL_PERDIDAS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PREVENCION_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PREVENCION_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de P.C.P. Región Central');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PREVENCION_Y_CONTROL_PERDIDAS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PCP_CPM]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PCP_CPM], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de P.C.P. Región Occidente');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PREVENCION_Y_CONTROL_PERDIDAS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PCP_CPAMC]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PCP_CPAMC], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de P.C.P. Región Oriente');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_PREVENCION_Y_CONTROL_PERDIDAS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PCP_CPJAA]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PCP_CPJAA], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        //ZIV-Salud
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Salud Integral');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_SALUD]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_SALUD_INTEGRAL_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_SALUD_INTEGRAL_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Salud Ocupacional');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_SALUD]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_SALUD_OPERACIONAL_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_SALUD_OPERACIONAL_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Planificación y Gestión');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_SALUD]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACION_Y_GESTION_SALUD_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACION_Y_GESTION_SALUD_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Salud Región Centro Morón');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_SALUD]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_SALUD_CPM]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_SALUD_CPM], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Salud Región Occidente CPAMC');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_SALUD]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_SALUD_CPAMC]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_SALUD_CPAMC], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Salud Región Oriente CPJAA');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_SALUD]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_SALUD_CPJAA]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_SALUD_CPJAA], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        //ZIV-Administración y Servicios
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Infraestructura');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_ADMINISTRACION_Y_SERVICIOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_INFRAESTRUCTURA_ADM_Y_SERV_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_INFRAESTRUCTURA_ADM_Y_SERV_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Apoyo');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_ADMINISTRACION_Y_SERVICIOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_APOYO_ADM_Y_SERV_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_APOYO_ADM_Y_SERV_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        //ZIV-Asuntos Públicos
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Relaciones Públicas');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_ASUNTOS_PUBLICOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_RELACIONES_PUBLICAS_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_RELACIONES_PUBLICAS_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Comunicaciones');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_ASUNTOS_PUBLICOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_COMUNICACIONES_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_COMUNICACIONES_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Org. de Eventos y Protocolo');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_ASUNTOS_PUBLICOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_ORG_DE_EVENTOS_Y_PROTOCOLO_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_ORG_DE_EVENTOS_Y_PROTOCOLO_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Asuntos Públics Morón');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_ASUNTOS_PUBLICOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_ASUNTOS_PUBLICOS_CPM]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_ASUNTOS_PUBLICOS_CPM], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Asuntos Públicos A.M.C.');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_ASUNTOS_PUBLICOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_ASUNTOS_PUBLICOS_CPAMC]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_ASUNTOS_PUBLICOS_CPAMC], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Relaciones Públicas J.A.A.');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_ASUNTOS_PUBLICOS]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_ASUNTOS_PUBLICOS_CPJAA]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_ASUNTOS_PUBLICOS_CPJAA], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        //ZIV-Desarrollo Social
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Coordinación de Desarrollo Social CPM');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_DESARROLLO_SOCIAL]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_DESARROLLO_SOCIAL_CPM]);
        $gerenciaSecond->setModular(true);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_DESARROLLO_SOCIAL_CPM], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia Regional de Desarrollo Integral Comunitario CPAMC');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_DESARROLLO_SOCIAL]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_REGIONAL_DESARROLLO_INTEGRAL_COMUNITARIO_CPAMC]);
        $gerenciaSecond->setModular(true);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_REGIONAL_DESARROLLO_INTEGRAL_COMUNITARIO_CPAMC], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia Regional de Desarrollo Integral Comunitario CPJAA');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_DESARROLLO_SOCIAL]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_REGIONAL_DESARROLLO_INTEGRAL_COMUNITARIO_CPJAA]);
        $gerenciaSecond->setModular(true);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_REGIONAL_DESARROLLO_INTEGRAL_COMUNITARIO_CPJAA], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        //ZIV-SHA
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Planificación y Control de Gestión');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_SEGURIDAD_HIGIENE_Y_AMBIENTE]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACION_Y_CONTROL_DE_GESTION_SHA_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACION_Y_CONTROL_DE_GESTION_SHA_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Ingeniería de Riesgo');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_SEGURIDAD_HIGIENE_Y_AMBIENTE]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_INGENIERIA_DE_RIESGO_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_INGENIERIA_DE_RIESGO_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Prev. Cont. de Emergencia y Contingencia');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_SEGURIDAD_HIGIENE_Y_AMBIENTE]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_PREV_CONT_DE_EMERG_Y_CONTINGENCIA_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_PREV_CONT_DE_EMERG_Y_CONTINGENCIA_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Ambiente e Higiene Ocupacional');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_SEGURIDAD_HIGIENE_Y_AMBIENTE]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_AMBIENTE_HIGIENE_OCUPACIONAL_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_AMBIENTE_HIGIENE_OCUPACIONAL_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Diseño SHA');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_SEGURIDAD_HIGIENE_Y_AMBIENTE]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_DISENO_SHA_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_DISENO_SHA_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia SHA CPM');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_SEGURIDAD_HIGIENE_Y_AMBIENTE]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_SHA_CPM]);
        $gerenciaSecond->setModular(true);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_SHA_CPM], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia SHA CPAMC');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_SEGURIDAD_HIGIENE_Y_AMBIENTE]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_SHA_CPAMC]);
        $gerenciaSecond->setModular(true);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_SHA_CPAMC], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia SHA CPJAA');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_SEGURIDAD_HIGIENE_Y_AMBIENTE]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_SHA_CPJAA]);
        $gerenciaSecond->setModular(true);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_SHA_CPJAA], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        //ZIV-SIG
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Estandarización SIG');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_SISTEMA_INTEGRADO_GESTION]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_ESTANDARIZACION_SIG_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_ESTANDARIZACION_SIG_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia de Mantenimiento SIG');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_SISTEMA_INTEGRADO_GESTION]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_MANTENIMIENTO_SIG_ZIV]);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_MANTENIMIENTO_SIG_ZIV], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia SIG Región Centro');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_SISTEMA_INTEGRADO_GESTION]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_MANTENIMIENTO_SIG_CPM]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_MANTENIMIENTO_SIG_CPM], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia SIG Región Occidente');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_SISTEMA_INTEGRADO_GESTION]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_MANTENIMIENTO_SIG_CPAMC]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_MANTENIMIENTO_SIG_CPAMC], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Gerencia SIG Región CPJAA');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
        $gerenciaSecond->setGerencia($this->getReference($refGerenciaNameArray[Gerencia::REF_GERENCIA_SISTEMA_INTEGRADO_GESTION]));
        $gerenciaSecond->setRef($refNameArray[GerenciaSecond::REF_GERENCIA_MANTENIMIENTO_SIG_CPJAA]);
        $gerenciaSecond->setVinculante(true);
        $this->addReference($refNameArray[GerenciaSecond::REF_GERENCIA_MANTENIMIENTO_SIG_CPJAA], $gerenciaSecond);
            $manager->persist($gerenciaSecond);
        
        $manager->flush();
    }
    
    public function getOrder(){
        return 4;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}