<?php

namespace Pequiven\SIGBundle\Model\Tracing;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
abstract class Standardization
{   
    /**
     *  Deteccion Control de Proceso
     *
     */
    const DETECTION_CP = 1;

    /**
     *  Deteccion Auditoria Interna
     *
     */
    const DETECTION_AI = 2;

    /**
     *  Deteccion Auditoria Externa
     *
     */
    const DETECTION_AE = 3;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="detection", type="integer")
     */
    protected $detection;

    /**
     *  Tipo de no Conformidad
     *
     */
    const TYPE_RE = 1;

    /**
     *  Tipo de no conformidad
     *
     */
    const TYPE_PO = 2;

    /**
     * @var integer
     *
     * @ORM\Column(name="type_nc", type="integer")
     */
    protected $type;
    
    /**
     * 
     * 
     * @param integer
     * @return 
     */
    function setDetection($detection) {
        $this->detection = $detection;
        return $this;
    }

    /**
     * 
     * 
     * @param integer
     * @return 
     */
    function getDetection() {       
        return $this->detection;
    }

    /**
     * 
     * 
     * @param integer
     * @return 
     */
    function setType($type) {
        $this->type = $type;
        return $this;
    }

    /**
     * 
     * 
     * @param integer
     * @return 
     */
    function getType() {       
        return $this->type;
    }

    static function getDetectionArray()
    {
        static $getDetectionArray = [
            self::DETECTION_CP => 'Control de Procesos',
            self::DETECTION_AI => 'Auditoria Interna',
            self::DETECTION_AE => 'Auditoria Externa',           
        ];
        return $getDetectionArray;
    }   

    static function getTypeNcArray()
    {
        static $getTypeNcArray = [
            self::TYPE_RE => 'Reales',
            self::TYPE_PO => 'Potenciales',
        ];
        return $getTypeNcArray;
    }   
    
}
