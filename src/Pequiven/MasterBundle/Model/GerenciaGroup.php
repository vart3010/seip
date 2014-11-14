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
    
    const TYPE_DEFAULT = 0;
    const TYPE_COMERCIALIZADORAS = 1;
    const TYPE_COMPLEJOS = 2;
    const TYPE_PROYECTOS = 3;
    const TYPE_SEDE_CORPORATIVA = 4;
    
    public $group_name = array();
    
    public function __construct() {
        $this->group_name[self::TYPE_DEFAULT] = 'SEDE CORPORATIVA';
        $this->group_name[self::TYPE_COMERCIALIZADORAS] = 'COMERCIALIZADORAS';
        $this->group_name[self::TYPE_COMPLEJOS] = 'COMPLEJOS';
        $this->group_name[self::TYPE_PROYECTOS] = 'PROYECTOS';
        $this->group_name[self::TYPE_SEDE_CORPORATIVA] = 'SEDE CORPORATIVA';
    }
    
    /**
     * Retorna todos los grupos de Gerencia de 1ra Línea
     * @return type
     */
    public function getGroupNameArray() {
        return $this->group_name;
    }
}
