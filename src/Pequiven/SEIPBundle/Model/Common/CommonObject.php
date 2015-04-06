<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\Model\Common;

use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * Description of CommonObject
 *
 * @author matias
 */
class CommonObject implements \Symfony\Component\DependencyInjection\ContainerAwareInterface {

    /**
     * Nivel Complejo
     */
    const LEVEL_COMPLEJO = 1;
    /**
     * Nivel Gerencia 1ra Línea
     */
    const LEVEL_GERENCIA = 2;
    /**
     * Nivel Gerencia 2da Línea
     */
    const LEVEL_GERENCIA_SECOND = 3;
    
    /**
     * 
     */
    const STATUS_WORKER_ACTIVE = 1;
    /**
     * 
     */
    const STATUS_WORKER_ASSIGNED = 2;
    /**
     * 
     */
    const STATUS_WORKER_SUPERNUMERARY = 3;
    /**
     * 
     */
    const STATUS_WORKER_OUTSIDE_COMPANY = 4;
    
    /**
     * Resultado para la evaluación
     */
    const TYPE_RESULT_EVALUATION = 'EVALUATION';
    
    /**
     * Resultado para la Gestión
     */
    const TYPE_RESULT_ARRANGEMENT = 'ARRANGEMENT';
    
    /**
     * Rango Bueno (Verde)
     */
    const TYPE_RANGE_GOOD = 'GOOD';
    
    /**
     * Rango Medio (Amarillo)
     */
    const TYPE_RANGE_MIDDLE = 'MIDDLE';
    
    /**
     * Rango Malo (Rojo)
     */
    const TYPE_RANGE_BAD = 'BAD';
    
    const OPEN_URL_OTHER_WINDOW = 0;
    
    const OPEN_URL_SAME_WINDOW = 1;
    
    protected $em;
    protected $class;
    protected $repository;
    protected $container;
    
    //put your code here
    public function __construct(){
        $this->CommonObject();
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    public function CommonObject(){
        $this->em = $this->container->get('doctrine')->getManager();
    }
    
    /**
     * Retorna las etiquetas definidas para los tipos de resumen
     * 
     * @staticvar array $labelsStatus
     * @return string
     */
    static function getLabelsStatusWorker()
    {
        static $labelsStatusWorker = array(
            self::STATUS_WORKER_ACTIVE => 'Trabajador Activo',
            self::STATUS_WORKER_ASSIGNED => 'Asignado',
            self::STATUS_WORKER_SUPERNUMERARY => 'Supernumerario',
            self::STATUS_WORKER_OUTSIDE_COMPANY => 'Fuera de la Compañía',
        );
        return $labelsStatusWorker;
    }
}
