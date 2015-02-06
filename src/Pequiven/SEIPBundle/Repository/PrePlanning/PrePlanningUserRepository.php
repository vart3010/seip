<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Repository\PrePlanning;

use Tecnocreaciones\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * Repositorio de la preplafinicacion del usuario
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PrePlanningUserRepository extends EntityRepository 
{
    /**
     * Devuelve el root de una pre planificacion
     * 
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @param \Pequiven\SEIPBundle\Entity\User $user
     * @return type
     */
    public function findTreePrePlanning(\Pequiven\SEIPBundle\Entity\Period $period,  \Pequiven\SEIPBundle\Entity\User $user,$levelPlanning)
    {
        
        $qb = $this->getQueryBuilder();
        $qb
            ->addSelect('p_p')
                
            ->leftJoin('p.prePlanningRoot', 'p_p')
                
            ->andWhere('p.period = :period')
            ->andWhere('p.user = :user')
            ->andWhere('p.levelPlanning = :levelPlanning')
            ->setParameter('period', $period)
            ->setParameter('user', $user)
            ->setParameter('levelPlanning', $levelPlanning)
            ;
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    protected function getAlias() {
        return 'p';
    }
}
