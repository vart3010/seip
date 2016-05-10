<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of RolRepository
 *
 * @author Gilbert C. <glavrjk@gmail.com>
 */
class RolRepository extends EntityRepository {

    function FindQBRolNotAdmin() {
        $qb = $this->createQueryBuilder('rol');
        $qb
                ->Select('rol')
                ->andWhere('rol.level!= :min')
                ->andWhere('rol.level!= :max')
                ->setParameter('min', 7000)
                ->setParameter('max', 8000)
        ;
        return $qb;
    }
    
    function getAlias() {
          return 'rol';
    }

}
