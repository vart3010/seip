<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Model;

/**
 * Description of LineStrategic
 *
 * @author matias
 */
class LineStrategic {
    //put your code here
    const LINE_DEFAULT = 0;
    const LINE_EFICIENCIA_CALIDAD = 1;
    const LINE_SOST_FINANCIERA = 2;
    const LINE_COMERCIALIZACION = 3;
    const LINE_CRECIMIENTO = 4;
    const LINE_SHA = 5;
    const LINE_GESTION_TALENTO = 6;
    const LINE_RESP_SOCIAL = 7;
    
    public $line_name = array();
    
    public function __construct() {
        $this->line_name[self::LINE_DEFAULT] = 'LINE_RESPONSABILIDAD_SOCIAL';
        $this->line_name[self::LINE_EFICIENCIA_CALIDAD] = 'LINE_EFICIENCIA_CALIDAD_PROCESOS';
        $this->line_name[self::LINE_SOST_FINANCIERA] = 'LINE_SOSTENIBILIDAD_FINANCIERA';
        $this->line_name[self::LINE_COMERCIALIZACION] = 'LINE_COMERCIALIZACION';
        $this->line_name[self::LINE_CRECIMIENTO] = 'LINE_CRECIMIENTO';
        $this->line_name[self::LINE_SHA] = 'LINE_SHA';
        $this->line_name[self::LINE_GESTION_TALENTO] = 'LINE_GESTION_TALENTO_HUMANO';
        $this->line_name[self::LINE_RESP_SOCIAL] = 'LINE_RESPONSABILIDAD_SOCIAL';
    }
    
    /**
     * Retorna todos los niveles
     * @return type
     */
    public function getLineNameArray() {
        return $this->line_name;
    }
    
    /**
     * Retorna los íconos de cada Línea Estratégica
     * 
     * @staticvar array $icons
     * @return string
     */
    static function getIcons()
    {
        static $icons = array(
            self::LINE_EFICIENCIA_CALIDAD => 'flaticon-mind',
            self::LINE_SOST_FINANCIERA => 'shop-coin16',
            self::LINE_COMERCIALIZACION => 'fa fa-external-link',
            self::LINE_CRECIMIENTO => 'fa fa-child',
            self::LINE_SHA => 'fa fa-tree',
            self::LINE_GESTION_TALENTO => 'fa fa-users',
            self::LINE_RESP_SOCIAL => 'flaticon-family5',
        );
        return $icons;
    }
}
