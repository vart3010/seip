<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Repository\CEI;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de planta
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PlantRepository extends SeipEntityRepository
{
    public function findByEntity($location) 
    {
        $qb = $this->getQueryAllEnabled();
        $qb
            ->andWhere("p.entity = :entity")
            ->setParameter("entity", $location)
            ;
        return $qb->getQuery()->getResult();
        
    }
    
    protected function getAlias() {
        return "p";
    }
}
