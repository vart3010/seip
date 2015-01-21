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
    public function findTreePrePlanning(\Pequiven\SEIPBundle\Entity\Period $period,  \Pequiven\SEIPBundle\Entity\User $user) {
        $qb = $this->getQueryBuilder();
        $qb
            ->addSelect('p_c')
            ->addSelect('p_p')
                
            ->leftJoin('p.childrens', 'p_c')
            ->leftJoin('p.parent', 'p_p')
                
            ->andWhere('p.period = :period')
            ->andWhere('p.user = :user')
            ->andWhere('p.name = :name')
            ->andWhere('p.typeObject = :typeObject')
            ->andWhere($qb->expr()->isNull('p.parent'))
            ->setParameter('period', $period)
            ->setParameter('user', $user)
            ->setParameter('name', \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning::DEFAULT_NAME)
            ->setParameter('typeObject', \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning::TYPE_OBJECT_ROOT_NODE)
            ;
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    protected function getAlias() {
        return 'p';
    }
}
