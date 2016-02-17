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

    static function getDetectionArray()
    {
        static $getDetectionArray = [
            self::DETECTION_CP => 'Control de Procesos',
            self::DETECTION_AI => 'Auditoria Interna',
            self::DETECTION_AE => 'Auditoria Externa',           
        ];
        return $getDetectionArray;
    }   
    
}
