<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\ObjetiveBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Description of ObjetiveLevelRepository
 *
 * @author matias
 */
class ObjetiveLevelRepository extends EntityRepository {
    //put your code here
    
    
    public function getByUser(){
        $em = $this->getEntityManager();
        $query = $em->createQueryBuilder()
                    ->select('ol')
                    ->from('\Pequiven\ObjetiveBundle\Entity\ObjetiveLevel', 'ol')
                    ->where('p.numPersonal = ' . $num_personal)
                    ->getQuery();
        return $query->getResult();
    }
}
