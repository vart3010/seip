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
}
