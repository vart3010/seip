<?php

namespace Pequiven\ArrangementProgramBundle\Repository;

use Tecnocreaciones\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Pequiven\SEIPBundle\Entity\Period;
use Pequiven\SEIPBundle\Entity\User;

/**
 * Repositorio de programa de gestion
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArrangementProgramRepository extends EntityRepository
{
    /**
     * Retorna los programas de gestion que tengan de responsable al usuario que cuenta como una
     */
    function findByUserAndPeriodNotGoals(User $user,Period $period,array $criteria = array())
    {
        $qb = $this->getQueryBuilder();
        $qb->innerJoin('ap.responsibles', 'ap_r')
           ->andWhere('ap_r.id = :responsible')
           ->andWhere('ap.period = :period')
           ->setParameter('responsible', $user)
           ->setParameter('period', $period);
        if(isset($criteria['notArrangementProgram'])){
            $qb->andWhere('ap.id != :arrangementProgram');
            $qb->setParameter('arrangementProgram', $criteria['notArrangementProgram']);
        }
        return $qb->getQuery()->getResult();
    }
    
    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        if(($ref = $criteria->remove('ap.ref'))){
            $queryBuilder->andWhere($queryBuilder->expr()->like('ap.ref',"'%".$ref."%'"));
        }
        if(($process = $criteria->remove('ap.process'))){
            $queryBuilder->andWhere($queryBuilder->expr()->like('ap.process',"'%".$process."%'"));
        }
        
//        if(($maxResults = $criteria->remove('max_results')) != null && $maxResults > 0){
//            $queryBuilder
//                    ->setMaxResults($maxResults)
//                    ;
//        }
        parent::applyCriteria($queryBuilder, $criteria->toArray());
    }
    protected function applySorting(\Doctrine\ORM\QueryBuilder $queryBuilder, array $sorting = null) {
        parent::applySorting($queryBuilder, $sorting);
    }
    
    protected function getAlias() {
        return 'ap';
    }
}
