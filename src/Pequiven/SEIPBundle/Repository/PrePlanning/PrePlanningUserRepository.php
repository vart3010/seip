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

use Pequiven\SEIPBundle\Entity\Period;
use Pequiven\SEIPBundle\Entity\User;
use Tecnocreaciones\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Pequiven\SEIPBundle\Model\PrePlanning\PrePlanning;

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
     * @param Period $period
     * @param User $user
     * @return type
     */
    public function findTreePrePlanning(Period $period,  User $user,$levelPlanning)
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
        
        $prePlanningConfiguration = $user->getConfiguration()->getPrePlanningConfiguration();
        if($levelPlanning == PrePlanning::LEVEL_TACTICO){
            
            $qb
                ->andWhere("p.gerenciaFirst = :gerenciaFirst")
                ->setParameter("gerenciaFirst",$prePlanningConfiguration->getGerencia())
                ;
        }else if($levelPlanning == PrePlanning::LEVEL_OPERATIVO){
            $qb
                ->andWhere("p.gerenciaSecond = :gerenciaSecond")
                ->setParameter("gerenciaSecond", $prePlanningConfiguration->getGerenciaSecond())
                ;
        }
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    function findWithIndicators(Period $period,array $criteria,$orderBy = null)
    {
        $qb = $this->getQueryBuilder();
        $qb
            ->addSelect('p_p')
                
            ->innerJoin('p.prePlanningRoot', 'p_p')
                
            ->andWhere('p.period = :period')
            ->andWhere('p.contentIndicator = :contentIndicator')
            ->setParameter('period', $period)
            ->setParameter('contentIndicator', true)
            ;
        $this->applyCriteria($qb,$criteria);
        $this->applySorting($qb,$orderBy);
        
        return $this->getPaginator($qb);
    }
    
    protected function getAlias() {
        return 'p';
    }
}
