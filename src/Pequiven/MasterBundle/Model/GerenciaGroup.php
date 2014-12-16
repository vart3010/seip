<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Model;

/**
 * Description of GerenciaGroup
 *
 * @author matias
 */
class GerenciaGroup extends \Pequiven\SEIPBundle\Model\Common\CommonObject {
    
    /**
     * Comercializadoras
     */
    const TYPE_COMERCIALIZADORAS = 'COME';
    /**
     * Complejos
     */
    const TYPE_COMPLEJOS = 'COMP';
    /**
     * Proyectos
     */
    const TYPE_PROYECTOS = 'PROY';
    /**
     * Corporativa
     */
    const TYPE_SEDE_CORPORATIVA = 'CORP';
}
