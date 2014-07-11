<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\Model\Common;

/**
 * Description of CommonObject
 *
 * @author matias
 */
abstract class CommonObject {
    protected $em;
    protected $class;
    protected $repository;
    protected $container;
    
    //put your code here
    public function __construct(\Doctrine\ORM\EntityManager $em, $class){
        $this->em = $em;
        $this->repository = $em->getRepository($class);
    }
}
