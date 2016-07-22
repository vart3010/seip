<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Model\Configurations;

/**
 * 
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class ConfigurationNotification {
    
    const REVIEW = 1;
    const NOTIFY = 2;
    const APROBE = 3;
    
    const TYPE_OBJECT             = 1;
    const TYPE_ARRANGEMENTPROGRAM = 2;
    const TYPE_INDICATOR          = 3;
    
    public function __construct() {        
    }
    
    /**
     * Retorna las acciones
     * 
     * @staticvar array $labelsStatus
     * @return string
     */
    static function getActions() {
        static $labelsActions = array(
            self::REVIEW => 'review',
            self::NOTIFY => 'notify',
            self::APROBE => 'aprobe',
        );
        return $labelsActions;
    }

    /**
     * Retorna las acciones
     * 
     * @staticvar array $labelsStatus
     * @return string
     */
    static function getObjects() {
        static $labelsObjects = array(
            self::TYPE_OBJECT => 'Object',
            self::TYPE_ARRANGEMENTPROGRAM => 'ArrangementProgram',
            self::TYPE_INDICATOR => 'Indicator',            
        );
        return $labelsObjects;
    }
}
