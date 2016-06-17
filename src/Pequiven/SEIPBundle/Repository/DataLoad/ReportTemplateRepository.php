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

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de Reporte plantilla
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ReportTemplateRepository extends SeipEntityRepository 
{
    /**
     * Busca un reporte con todos los datos pre establecidos
     * @param type $id
     * @param DateTime $dateNotification
     * @return type
     */
    public function findToNotify($id,  DateTime $dateNotification,$plantReport = null)
    {
        $month = $dateNotification->format("m");
        
        $qb = $this->getQueryBuilder();
        $qb
            ->addSelect('rt_pr')
            ->addSelect('rt_pr_pr')
            ->addSelect('rt_pr_pr_up')
            ->addSelect('rt_pr_cps')
            ->addSelect('rt_pr_cps_dcps')
            ->addSelect('rt_pr_pr_rcp')
            ->addSelect('rt_pr_pr_rcp_drmc')
            ->addSelect('rt_pr_pr_pddm')
            ->addSelect('rt_pr_pr_i')
                
            ->innerJoin('rt.plantReports','rt_pr')
            ->innerJoin('rt_pr.productsReport','rt_pr_pr')
            ->innerJoin('rt_pr_pr.unrealizedProductions','rt_pr_pr_up',Join::WITH,'rt_pr_pr_up.month = :month')
                
            ->leftJoin('rt_pr.consumerPlanningServices','rt_pr_cps')
            ->leftJoin('rt_pr_cps.detailConsumerPlanningServices','rt_pr_cps_dcps',Join::WITH,'rt_pr_cps_dcps.month = :month')
                
            ->leftJoin('rt_pr_pr.rawMaterialConsumptionPlannings','rt_pr_pr_rcp')
            ->leftJoin('rt_pr_pr_rcp.detailRawMaterialConsumptions','rt_pr_pr_rcp_drmc',Join::WITH,'rt_pr_pr_rcp_drmc.month = :month')
                
            ->leftJoin('rt_pr_pr.productDetailDailyMonths','rt_pr_pr_pddm',Join::WITH,'rt_pr_pr_pddm.month = :month')
                
            ->leftJoin('rt_pr_pr.inventorys','rt_pr_pr_i', Join::WITH,'rt_pr_pr_i.month = :month')
                
            ->andWhere('rt.id = :id')
                
            ->setParameter('id', $id)
            ->setParameter('month', $month)
            ;
        if($plantReport !== null){
            $qb
                ->andWhere("rt_pr.id = :plantReport")
                ->setParameter("plantReport", $plantReport)
                ;
        }
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    public function findReportTemplatesByPeriod($period){
        $qb = $this->getQueryBuilder();
        
        $qb->andWhere("rt.period = ".$period);
        
        return $qb->getQuery()->getResult();
    }
    
    /**
     * Retorna las plantillas a las cuales el usuario tiene acceso
     * @param array $criteria
     * @param array $orderBy
     * @return type
     */
    public function createPaginatorByUser(array $criteria = null, array $orderBy = null) 
    {
        $queryBuilder = $this->getCollectionQueryBuilder();
        $user = $this->getUser();
        
       if(!$this->getSecurityContext()->isGranted(array('ROLE_SEIP_OPERATION_LIST_PLANNING_PRODUCTION_TEMPLATES_ALL'))){
           $queryBuilder
                ->innerJoin("rt.users", 'rt_u')
                ->andWhere("rt_u.id = :user")
                ->setParameter("user", $user)
                ;
       }
       
        $this->applyCriteria($queryBuilder, $criteria);
        $this->applySorting($queryBuilder, $orderBy);

        return $this->getPaginator($queryBuilder);
    }
    
    /**
     * 
     */
    public function getQueryBuilderByUser(){
        $queryBuilder = $this->getCollectionQueryBuilder();
        $user = $this->getUser();
        
       if(!$this->getSecurityContext()->isGranted(array('ROLE_SEIP_OPERATION_LIST_PLANNING_PRODUCTION_TEMPLATES_ALL'))){
           $queryBuilder
                ->innerJoin("rt.users", 'rt_u')
                ->andWhere("rt_u.id = :user")
                ->setParameter("user", $user)
                ;
       }
       
       $this->applyPeriodCriteria($queryBuilder);
       
       return $queryBuilder;
    }
    
    protected function applyCriteria(QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new ArrayCollection($criteria);
        $queryBuilder
                    ->leftJoin("rt.plantReports","rt_pr");
        
        if(($ref = $criteria->remove("rt.ref")))
        {
            $queryBuilder->andWhere($queryBuilder->expr()->like("rt.ref","'%".$ref."%'"));
        }
        if(($name = $criteria->remove("rt.name")))
        {
            $queryBuilder->andWhere($queryBuilder->expr()->like("rt.name","'%".$name."%'"));
        }
        if(($plant = $criteria->remove("plant")))
        {
            $queryBuilder
                    ->innerJoin("rt_pr.plant","rt_pr_p")
                    ->andWhere("rt_pr_p.id = :plant")
                    ->setParameter('plant', $plant)
                    ;
        }
        if(($entity = $criteria->remove("entity")))
        {
            $queryBuilder
                    ->innerJoin("rt_pr.entity","rt_pr_e")
                    ->andWhere("rt_pr_e.id = :entity")
                    ->setParameter('entity', $entity)
                    ;
        }
        if(($product = $criteria->remove("product")))
        {
            if(!is_array($product)){
                $product = json_decode($product);
            }
            if(count($product) > 0){
                $queryBuilder
                        ->innerJoin("rt_pr.productsReport","rt_pr_pr")
                        ->innerJoin("rt_pr_pr.product","rt_pr_pr_p")
                        ->andWhere($queryBuilder->expr()->in("rt_pr_pr_p.id", $product))
                        ;
            }
        }
        if(($service = $criteria->remove("service")))
        {
            if(!is_array($service)){
                $service = json_decode($service);
            }
            if(count($service) > 0){
                $queryBuilder
                        ->innerJoin("rt_pr.consumerPlanningServices","rt_pr_cps")
                        ->innerJoin("rt_pr_cps.service","rt_pr_cps_s")
                        ->andWhere($queryBuilder->expr()->in("rt_pr_cps_s.id", $service))
                        ;
            }
        }
        
        //return parent::applyCriteria($queryBuilder, $criteria->toArray());
        
        $applyPeriodCriteria = $criteria->remove('applyPeriodCriteria');
        
        parent::applyCriteria($queryBuilder, $criteria->toArray());
        
        if($applyPeriodCriteria){
           $this->applyPeriodCriteria($queryBuilder);
        }
    }
    
    protected function getAlias() {
        return "rt";
    }
}
