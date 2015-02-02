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
 * Repositorio de pre planificacion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PrePlanningRepository extends EntityRepository
{
    /**
     * Devuelve el root de una pre planificacion
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @param \Pequiven\SEIPBundle\Entity\User $user
     * @return type
     */
    public function findTreePrePlanning(\Pequiven\SEIPBundle\Entity\Period $period,  \Pequiven\SEIPBundle\Entity\User $user,$levelPlanning)
    {
        
        $qb = $this->getQueryBuilder();
        $qb
            ->addSelect('p_c')
            ->addSelect('p_p')
                
            ->leftJoin('p.childrens', 'p_c')
            ->leftJoin('p.parent', 'p_p')
                
            ->andWhere('p.period = :period')
            ->andWhere('p.user = :user')
            ->andWhere('p.name = :name')
            ->andWhere('p.levelPlanning = :levelPlanning')
            ->andWhere('p.typeObject = :typeObject')
            ->andWhere($qb->expr()->isNull('p.parent'))
            ->setParameter('period', $period)
            ->setParameter('user', $user)
            ->setParameter('levelPlanning', $levelPlanning)
            ->setParameter('name', \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning::DEFAULT_NAME)
            ->setParameter('typeObject', \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning::TYPE_OBJECT_ROOT_NODE)
            ;
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    public function findIn(array $ids) {
        $qb = $this->getQueryBuilder();
        $qb->andWhere($qb->expr()->in('p.id', $ids));
        return $qb->getQuery()->getResult();
    }
    
    protected function getAlias() {
        return 'p';
    }
}
