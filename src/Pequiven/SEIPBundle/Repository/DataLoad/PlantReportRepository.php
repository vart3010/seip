<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Repository\DataLoad;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de reporte de planta
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PlantReportRepository extends SeipEntityRepository 
{   
    public function findByPlantReport() 
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder
            ->select('pr')
            ->andWhere('pr.period = :period')
            ->setParameter('period',2)
            ;

        return $queryBuilder;
    }
    
    public function findPlantReportByEntityPeriod($period,$entity) 
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder
            ->select('pr')
            ->andWhere('pr.period = :period')
            ->setParameter('period',2)
            ;

        return $queryBuilder;
    }
    
    public function findInnerProductsReport($plantReport,$productsReport) 
    {
        $qb = $this->getQueryBuilder();
        $qb
            ->addSelect('pr_pr')
            ->addSelect('pr_pr_p')
                
            ->innerJoin('pr.productsReport','pr_pr')
            ->innerJoin('pr_pr.product','pr_pr_p')
                
//            ->andWhere($qb->expr()->in('pr_pr_p.id',array(2107)))
            ->andWhere('pr.id = :id')
            ->setParameter('id', $plantReport)
            ;
        return $qb->getQuery()->getOneOrNullResult();
    }
    public function createPaginatorByUser(array $criteria = null, array $orderBy = null) 
    {
        $queryBuilder = $this->getCollectionQueryBuilder();
        $user = $this->getUser();

        $queryBuilder
                ->innerJoin("pr.users", 'pr_u')
                ->andWhere("pr_u.id = :user")
                ->setParameter("user", $user)
                ;
        
        $this->applyCriteria($queryBuilder, $criteria);
        $this->applySorting($queryBuilder, $orderBy);

        return $this->getPaginator($queryBuilder);
    }
    
    public function getQueryBuilderByUser(){
        $queryBuilder = $this->getCollectionQueryBuilder();
        $user = $this->getUser();

        if(!$this->getSecurityContext()->isGranted(array('ROLE_SEIP_OPERATION_LIST_PLANNING_PRODUCTION_TEMPLATES_ALL'))){
            $queryBuilder
                ->innerJoin("pr.reportTemplate", 'rt')
                ->innerJoin("rt.users", 'rt_u')
                ->andWhere("rt_u.id = :user")
                ->setParameter("user", $user)
                ;
        }
        
        $this->applyPeriodCriteria($queryBuilder);
        
        return $queryBuilder;
    }
    
    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) 
    {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        $plantName = $criteria->remove("pr.plant.name");
        if($plantName != null){
            $queryBuilder
                    ->innerJoin('pr.plant', 'pr_p')
                    ->andWhere($queryBuilder->expr()->like("pr_p.name", $queryBuilder->expr()->literal("%".$plantName."%")))
                ;
        }
        $reportTemplate = $criteria->remove("pr.reportTemplate");
        if($reportTemplate != null){
            $queryBuilder
                    ->innerJoin('pr.reportTemplate', 'pr_rt')
                    ->andWhere(
                            $queryBuilder->expr()->orX(
                                    $queryBuilder->expr()->like("pr_rt.name", $queryBuilder->expr()->literal("%".$reportTemplate."%")),
                                    $queryBuilder->expr()->like("pr_rt.ref", $queryBuilder->expr()->literal("%".$reportTemplate."%"))
                                )
                        )
                ;
        }
        
        $applyPeriodCriteria = $criteria->remove('applyPeriodCriteria');
        
        parent::applyCriteria($queryBuilder, $criteria->toArray());
        
        if($applyPeriodCriteria){
           $this->applyPeriodCriteria($queryBuilder);
        }
    }
    
    protected function getAlias() 
    {
        return 'pr';
    }
}
