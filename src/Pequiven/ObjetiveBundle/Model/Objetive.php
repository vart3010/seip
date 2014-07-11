<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\ObjetiveBundle\Model;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;



/**
 * Description of Objetive
 *
 * @author matias
 */
class Objetive implements ContainerAwareInterface {
    protected $container;
    
    //put your code here
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    public function create(){
        
    }
}
