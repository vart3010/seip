<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\Model;

/**
 * Description of Monitor
 *
 * @author matias
 */
abstract class Monitor {
    //put your code here
    
    //Tipos de vista del monitor de producción
    
    /**
     * 
     */
    const MONITOR_PRODUCTION_VIEW_STATUS_CHARGE = 0;
    
    /**
     * 
     */
    const MONITOR_PRODUCTION_VIEW_COMPLIANCE = 1;
}
