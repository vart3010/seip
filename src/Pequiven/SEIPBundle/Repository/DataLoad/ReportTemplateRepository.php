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
 * Repositorio de Reporte plantilla
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ReportTemplateRepository extends SeipEntityRepository 
{
    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        //
        
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
                    ->innerJoin("rt.plantReports","rt_pr")
                    ->innerJoin("rt_pr.plant","rt_pr_p")
                    ->andWhere("rt_pr_p.id = :plant")
                    ->setParameter('plant', $plant)
                    ;
        }
        if(($entity = $criteria->remove("entity")))
        {
            $queryBuilder
                    ->innerJoin("rt.plantReports","rt_pr")
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
                        ->innerJoin("rt.plantReports","rt_pr")
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
                        ->innerJoin("rt.plantReports","rt_pr")
                        ->innerJoin("rt_pr.consumerPlanningServices","rt_pr_cps")
                        ->innerJoin("rt_pr_cps.service","rt_pr_cps_s")
                        ->andWhere($queryBuilder->expr()->in("rt_pr_cps_s.id", $service))
                        ;
            }
        }
        
        return parent::applyCriteria($queryBuilder, $criteria->toArray());
    }
    
    protected function getAlias() {
        return "rt";
    }
}
