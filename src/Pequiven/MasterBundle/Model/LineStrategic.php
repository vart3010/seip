<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Model;

use Doctrine\ORM\Mapping as ORM;


/**
 * Description of LineStrategic
 *
 * @author matias
 */
abstract class LineStrategic {
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
            self::LINE_EFICIENCIA_CALIDAD => 'bundles/pequivenseip/icons/icon_mind.png',
            self::LINE_SOST_FINANCIERA => 'bundles/pequivenseip/icons/icon_coin.png',
            self::LINE_COMERCIALIZACION => 'bundles/pequivenseip/icons/icon_businessmen.png',
            self::LINE_CRECIMIENTO => 'bundles/pequivenseip/icons/icon_graphic.png',
            self::LINE_SHA => 'bundles/pequivenseip/icons/icon_worker.png',
            self::LINE_GESTION_TALENTO => 'bundles/pequivenseip/icons/icon_connected.png',
            self::LINE_RESP_SOCIAL => 'bundles/pequivenseip/icons/icon_family.png',
        );
        return $icons;
    }
    
    /**
     * Retorna los íconos de cada Línea Estratégica
     * 
     * @staticvar array $icons
     * @return string
     */
    static function getIconsMin()
    {
        static $icons = array(
            self::LINE_EFICIENCIA_CALIDAD => 'bundles/pequivenseip/icons/icon_mind.png',
            self::LINE_SOST_FINANCIERA => 'bundles/pequivenseip/icons/icon_coin.png',
            self::LINE_COMERCIALIZACION => 'bundles/pequivenseip/icons/icon_businessmen.png',
            self::LINE_CRECIMIENTO => 'bundles/pequivenseip/icons/icon_graphic.png',
            self::LINE_SHA => 'bundles/pequivenseip/icons/icon_worker.png',
            self::LINE_GESTION_TALENTO => 'bundles/pequivenseip/icons/icon_connected.png',
            self::LINE_RESP_SOCIAL => 'bundles/pequivenseip/icons/icon_family.png',
        );
        return $icons;
    }
}
