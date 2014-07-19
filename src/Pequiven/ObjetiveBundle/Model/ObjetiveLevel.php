<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\ObjetiveBundle\Model;

/**
 * Description of ObjetiveLevel
 *
 * @author matias
 */
class ObjetiveLevel extends \Pequiven\SEIPBundle\Model\Common\CommonObject {
    //put your code here
    const LEVEL_DEFAULT = 0;
    const LEVEL_ESTRATEGICO = 1;
    const LEVEL_TACTICO = 2;
    const LEVEL_OPERATIVO = 3;
    
    public $level_name = array();
    
    public function __construct() {
        $this->level_name[self::LEVEL_DEFAULT] = 'OBJETIVO_ESTRATEGICO';
        $this->level_name[self::LEVEL_ESTRATEGICO] = 'OBJETIVO_ESTRATEGICO';
        $this->level_name[self::LEVEL_TACTICO] = 'OBJETIVO_TACTICO';
        $this->level_name[self::LEVEL_OPERATIVO] = 'OBJETIVO_OPERATIVO';
    }
    
    public function fetchBy(\Doctrine\ORM\EntityManager $em ,$options = array()){
        $object = $em->getRepository('PequivenObjetiveBundle:ObjetiveLevel')->findBy($options);
        return $object;
    }
    
    public function fetchOneBy(\Doctrine\ORM\EntityManager $em ,$options = array()){
        $object = $em->getRepository('PequivenObjetiveBundle:ObjetiveLevel')->findOneBy($options);
        return $object;
    }
    
    /**
     * Retorna todos los niveles
     * @return type
     */
    public function getLevelNameArray() {
        return $this->level_name;
    }
    
}
