<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Model;

/**
 * Description of Gerencia
 *
 * @author matias
 */
abstract class Gerencia implements GerenciaFirstInterface
{
    
    /**
     * Incluye las gerencias de apoyo
     */
    const TYPE_WITH_GERENCIA_SECOND_SUPPORT = 'TYPE_WITH_GERENCIA_SECOND_SUPPORT';
    
    /**
     * Excluye las gerencias de apoyo
     */
    const TYPE_WITHOUT_GERENCIA_SECOND_SUPPORT = 'TYPE_WITHOUT_GERENCIA_SECOND_SUPPORT';
    
    //Referencias de las Gerencias de 1ra Línea
    //Morón
    const REF_GERENCIA_GENERAL_CPM = 1;
    const REF_GERENCIA_UNFER = 2;
    const REF_GERENCIA_UNPI = 3;
    const REF_GERENCIA_PROYECTOS_MORON = 4;
    const REF_GERENCIA_LOGISTICA_COMERCIAL = 5;
    const REF_GERENCIA_IPSL_COMERCIO_EXTERIOR = 6;
    //AMC
    const REF_GERENCIA_GENERAL_CPAMC = 7;
    const REF_GERENCIA_UNOP = 8;
    //JAA
    const REF_GERENCIA_GENERAL_CPJAA = 9;
    //NAVAY
    const REF_GERENCIA_GENERAL_NAVAY = 10;
    //ZIV
    const REF_GERENCIA_ESTIMACION_COSTOS = 11;
    const REF_GERENCIA_CONTROL_GESTION_OFIC_PRESIDENCIA = 12;
    const REF_GERENCIA_TRANSPORTE_AEREO = 13;
    const REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS = 14;
    const REF_GERENCIA_SEG_CTROL_FINANCIERO_ADMVO_PROY = 15;
    const REF_GERENCIA_PROYECTOS_INTERNACIONALES = 16;
    const REF_GERENCIA_PROYECTO_TERMINAL_MARITIMO_CPM = 17;
    const REF_GERENCIA_RECURSOS_HUMANOS = 18;
    const REF_GERENCIA_AUDITORIA_INTERNA = 19;
    const REF_GERENCIA_CONSULTORIA_JURIDICA_Y_RPTE_JUDICIAL = 20;
    const REF_GERENCIA_CONTRATACIONES = 21;
    const REF_GERENCIA_FINANZAS = 22;
    const REF_GERENCIA_AUTOMATIZACION_INFORMATICA_Y_TELECOMUNICACIONES = 23;
    const REF_GERENCIA_PREVENCION_Y_CONTROL_PERDIDAS = 24;
    const REF_GERENCIA_SALUD = 25;
    const REF_GERENCIA_ADMINISTRACION_Y_SERVICIOS = 26;
    const REF_GERENCIA_ASUNTOS_PUBLICOS = 27;
    const REF_GERENCIA_DESARROLLO_SOCIAL = 28;
    const REF_GERENCIA_SEGURIDAD_HIGIENE_Y_AMBIENTE = 29;
    const REF_GERENCIA_SISTEMA_INTEGRADO_GESTION = 30;
    const REF_GERENCIA_DIRECCION_PROYECTOS = 31;
    const REF_GERENCIA_OFICINA_PRESIDENCIA = 32;
    const REF_GERENCIA_PROYECTOS_REVOLUCION_PETROQUIMICA = 33;
    
    //Tipo de Gerencias (Medular o Vinculante)
    const GERENCIA_TYPE_MODULAR = 1;//En caso de que sólo exista en complejos y no en Sede Corporativa
    const GERENCIA_TYPE_VINCULANTE = 2;//En caso de que existe también en Sede Corporativa
    
    protected $refName = array();
    
    public function __construct() {
        //Morón
        $this->refName[self::REF_GERENCIA_GENERAL_CPM] = 'GERENCIA_GENERAL_CPM';
        $this->refName[self::REF_GERENCIA_UNFER] = 'GERENCIA_UNFER';
        $this->refName[self::REF_GERENCIA_UNPI] = 'GERENCIA_UNPI';
        $this->refName[self::REF_GERENCIA_PROYECTOS_MORON] = 'GERENCIA_PROYECTOS_MORON';
        $this->refName[self::REF_GERENCIA_LOGISTICA_COMERCIAL] = 'GERENCIA_LOGISTICA_COMERCIAL';
        $this->refName[self::REF_GERENCIA_IPSL_COMERCIO_EXTERIOR] = 'GERENCIA_IPSL_COMERCIO_EXTERIOR';
        //AMC
        $this->refName[self::REF_GERENCIA_GENERAL_CPAMC] = 'GERENCIA_GENERAL_CPAMC';
        $this->refName[self::REF_GERENCIA_UNOP] = 'GERENCIA_UNOP';
        //JAA
        $this->refName[self::REF_GERENCIA_GENERAL_CPJAA] = 'GERENCIA_GENERAL_CPJAA';
        //NAVAY
        $this->refName[self::REF_GERENCIA_GENERAL_NAVAY] = 'GERENCIA_GENERAL_NAVAY';
        //ZIV
        $this->refName[self::REF_GERENCIA_ESTIMACION_COSTOS] = 'GERENCIA_ESTIMACION_COSTOS';
        $this->refName[self::REF_GERENCIA_CONTROL_GESTION_OFIC_PRESIDENCIA] = 'GERENCIA_CONTROL_GESTION_OFIC_PRESIDENCIA';        
        $this->refName[self::REF_GERENCIA_TRANSPORTE_AEREO] = 'GERENCIA_TRANSPORTE_AEREO';
        $this->refName[self::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS ] = 'GERENCIA_PLANIFICACIÓN_ESTRATEGICA_NUEVOS_DESARROLLOS';
        $this->refName[self::REF_GERENCIA_SEG_CTROL_FINANCIERO_ADMVO_PROY] = 'GERENCIA_SEG_CTROL_FINANCIERO_ADMVO_PROY';
        $this->refName[self::REF_GERENCIA_PROYECTOS_INTERNACIONALES] = 'GERENCIA_PROYECTOS_INTERNACIONALES';
        $this->refName[self::REF_GERENCIA_PROYECTO_TERMINAL_MARITIMO_CPM] = 'GERENCIA_PROYECTO_TERMINAL_MARITIMO_CPM';
        $this->refName[self::REF_GERENCIA_RECURSOS_HUMANOS] = 'GERENCIA_RECURSOS_HUMANOS';
        $this->refName[self::REF_GERENCIA_AUDITORIA_INTERNA] = 'Aud.Int.';
        $this->refName[self::REF_GERENCIA_CONSULTORIA_JURIDICA_Y_RPTE_JUDICIAL] = 'GERENCIA_CONSULTORIA_JURIDICA_Y_RPTE_JUDICIAL';
        $this->refName[self::REF_GERENCIA_CONTRATACIONES] = 'GERENCIA_CONTRATACIONES';
        $this->refName[self::REF_GERENCIA_FINANZAS] = 'GERENCIA_FINANZAS';
        $this->refName[self::REF_GERENCIA_AUTOMATIZACION_INFORMATICA_Y_TELECOMUNICACIONES] = 'GERENCIA_AUTOMATIZACION_INFORMATICA_Y_TELECOMUNICACIONES';
        $this->refName[self::REF_GERENCIA_PREVENCION_Y_CONTROL_PERDIDAS] = 'GERENCIA_PREVENCION_Y_CONTROL_PERDIDAS';
        $this->refName[self::REF_GERENCIA_SALUD] = 'GERENCIA_SALUD';
        $this->refName[self::REF_GERENCIA_ADMINISTRACION_Y_SERVICIOS] = 'GERENCIA_ADMINISTRACION_Y_SERVICIOS';
        $this->refName[self::REF_GERENCIA_ASUNTOS_PUBLICOS] = 'GERENCIA_ASUNTOS_PUBLICOS';
        $this->refName[self::REF_GERENCIA_DESARROLLO_SOCIAL] = 'GERENCIA_DESARROLLO_SOCIAL';
        $this->refName[self::REF_GERENCIA_SEGURIDAD_HIGIENE_Y_AMBIENTE] = 'GERENCIA_SEGURIDAD_HIGIENE_Y_AMBIENTE';
        $this->refName[self::REF_GERENCIA_SISTEMA_INTEGRADO_GESTION] = 'GERENCIA_SISTEMA_INTEGRADO_GESTION';
        $this->refName[self::REF_GERENCIA_DIRECCION_PROYECTOS] = 'GERENCIA_DIRECCION_PROYECTOS';
        $this->refName[self::REF_GERENCIA_OFICINA_PRESIDENCIA] = 'GERENCIA_OFICINA_PRESIDENCIA';
        $this->refName[self::REF_GERENCIA_PROYECTOS_REVOLUCION_PETROQUIMICA] = 'GERENCIA_PROYECTOS_REVOLUCION_PETROQUIMICA';
    }
    
    /**
     * Retorna todas las referencias o códigos de las gerencias de 1ra línea
     * @return type
     */
    public function getRefNameArray() {
        return $this->refName ;
    }
    
    public function __toString() {
        return $this->description ?:'-';
    }
    
    /**
     * Devuelve los objetivos a nivel tactico porque es una gerencia de segunda linea.
     * @return type
     */
    public function getObjetives() {
        $objetives = array();
        $tacticalObjectives = $this->getTacticalObjectives();
        foreach ($tacticalObjectives as $objetive) {
            if($objetive->getObjetiveLevel()->getLevel() !== \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO){
                continue;
            }
            $objetives[] = $objetive;
        }
        return $objetives;
    }
    
    /**
     * Retorna las referencias definidas para las Gerencias de 1ra Línea
     * 
     * @staticvar array $labelsResume
     * @return string
     */
    static function getLabelsResume()
    {
        static $labelsResume = array(
            self::REF_GERENCIA_GENERAL_CPM => 'GERENCIA_GENERAL_CPM',
            self::REF_GERENCIA_UNFER => 'GERENCIA_UNFER',
            self::REF_GERENCIA_UNPI => 'GERENCIA_UNPI',
            self::REF_GERENCIA_PROYECTOS_MORON => 'GERENCIA_PROYECTOS_MORON',
            self::REF_GERENCIA_LOGISTICA_COMERCIAL => 'GERENCIA_LOGISTICA_COMERCIAL',
            self::REF_GERENCIA_IPSL_COMERCIO_EXTERIOR => 'GERENCIA_IPSL_COMERCIO_EXTERIOR',
            //AMC
            self::REF_GERENCIA_GENERAL_CPAMC => 'GERENCIA_GENERAL_CPAMC',
            self::REF_GERENCIA_UNOP => 'GERENCIA_UNOP',
            //JAA
            self::REF_GERENCIA_GENERAL_CPJAA => 'GERENCIA_GENERAL_CPJAA',
            //NAVAY
            self::REF_GERENCIA_GENERAL_NAVAY => 'GERENCIA_GENERAL_NAVAY',
            //ZIV
            self::REF_GERENCIA_ESTIMACION_COSTOS => 'GERENCIA_ESTIMACION_COSTOS',
            self::REF_GERENCIA_CONTROL_GESTION_OFIC_PRESIDENCIA => 'GERENCIA_CONTROL_GESTION_OFIC_PRESIDENCIA',
            self::REF_GERENCIA_TRANSPORTE_AEREO => 'GERENCIA_TRANSPORTE_AEREO',
            self::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS => 'GERENCIA_PLANIFICACIÓN_ESTRATEGICA_NUEVOS_DESARROLLOS',
            self::REF_GERENCIA_SEG_CTROL_FINANCIERO_ADMVO_PROY => 'GERENCIA_SEG_CTROL_FINANCIERO_ADMVO_PROY',
            self::REF_GERENCIA_PROYECTOS_INTERNACIONALES => 'GERENCIA_PROYECTOS_INTERNACIONALES',
            self::REF_GERENCIA_PROYECTO_TERMINAL_MARITIMO_CPM => 'GERENCIA_PROYECTO_TERMINAL_MARITIMO_CPM',
            self::REF_GERENCIA_RECURSOS_HUMANOS => 'GERENCIA_RECURSOS_HUMANOS',
            self::REF_GERENCIA_AUDITORIA_INTERNA => 'Aud.Int.',
            self::REF_GERENCIA_CONSULTORIA_JURIDICA_Y_RPTE_JUDICIAL => 'GERENCIA_CONSULTORIA_JURIDICA_Y_RPTE_JUDICIAL',
            self::REF_GERENCIA_CONTRATACIONES => 'GERENCIA_CONTRATACIONES',
            self::REF_GERENCIA_FINANZAS => 'GERENCIA_FINANZAS',
            self::REF_GERENCIA_AUTOMATIZACION_INFORMATICA_Y_TELECOMUNICACIONES => 'GERENCIA_AUTOMATIZACION_INFORMATICA_Y_TELECOMUNICACIONES',
            self::REF_GERENCIA_PREVENCION_Y_CONTROL_PERDIDAS => 'GERENCIA_PREVENCION_Y_CONTROL_PERDIDAS',
            self::REF_GERENCIA_SALUD => 'GERENCIA_SALUD',
            self::REF_GERENCIA_ADMINISTRACION_Y_SERVICIOS => 'GERENCIA_ADMINISTRACION_Y_SERVICIOS',
            self::REF_GERENCIA_ASUNTOS_PUBLICOS => 'GERENCIA_ASUNTOS_PUBLICOS',
            self::REF_GERENCIA_DESARROLLO_SOCIAL => 'GERENCIA_DESARROLLO_SOCIAL',
            self::REF_GERENCIA_SEGURIDAD_HIGIENE_Y_AMBIENTE => 'GERENCIA_SEGURIDAD_HIGIENE_Y_AMBIENTE',
            self::REF_GERENCIA_SISTEMA_INTEGRADO_GESTION => 'GERENCIA_SISTEMA_INTEGRADO_GESTION',
            self::REF_GERENCIA_DIRECCION_PROYECTOS => 'GERENCIA_DIRECCION_PROYECTOS',
            self::REF_GERENCIA_OFICINA_PRESIDENCIA => 'GERENCIA_OFICINA_PRESIDENCIA',
            self::REF_GERENCIA_PROYECTOS_REVOLUCION_PETROQUIMICA => 'GERENCIA_PROYECTOS_REVOLUCION_PETROQUIMICA',
        );
        return $labelsResume;
    }
}
