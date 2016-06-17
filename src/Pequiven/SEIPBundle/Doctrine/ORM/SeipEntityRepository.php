<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Doctrine\ORM;

use Doctrine\ORM\QueryBuilder;
use Pequiven\SEIPBundle\Service\PeriodService;
use Tecnocreaciones\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * Repositorio base para entidades seip
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class SeipEntityRepository extends EntityRepository
{
    public function getQueryPeriod()
    {
        $qb = $this->getQueryBuilder();
        $this->applyPeriodCriteria($qb);
        return $qb;
    }    
    
    /**
     * 
     * @return QueryBuilder
     */
    public function getQueryAllEnabled()
    {
        $qb = $this->getQueryBuilder();
        $qb
            ->andWhere($this->getAlias().'.enabled = :enabled')
            ->setParameter('enabled', true)
            ;
        return $qb;
    }
    
    /**
     * @return array
     */
    public function getAllActive()
    {
        return $this
            ->getQueryBuilder()
        ;
    }
    
    public function getAllEnabled()
    {
        $qb = $this->getQueryAllEnabled();
        return $qb->getQuery()->getResult();
    }
    
    public function findSearch(array $criteria,$options = array())
    {
        $name = $criteria['name'];
        $property = 'name';
        if(isset($options['property'])){
            $property = $options['property'];
        }
        $qb = $this->getQueryAllEnabled();
        $qb
            ->andWhere($qb->expr()->like($this->getAlias().".".$property, "'%$name%'"))
            ;
        $qb->setMaxResults(20);
        return $qb->getQuery()->getResult();
    }


    protected function applyPeriodCriteria(QueryBuilder &$queryBuilder, $alias = null) 
    {
        if($alias === null){
        
            $alias = $this->getAlias();
        }
        $periodId = $this->getRequest()->get("_period");
        $queryBuilder->andWhere($alias.'.period = :period');
        $periodValid = null;
        if($periodId !== null){
            $periodService = $this->getPeriodService();
            $period = $periodService->find($periodId);
            if($period !== null){
                $periodValid = $period;
            }
        }
        
        if($periodValid !== null){
            $queryBuilder
            ->setParameter('period',$periodValid)
            ;
        }else{
            $this->setParameterPeriod($queryBuilder);
        }
    } 
    
    protected function setParameterPeriod(QueryBuilder &$queryBuilder)
    {
        $periodService = $this->getPeriodService();
        $queryBuilder
                ->setParameter('period', $periodService->getPeriodActive())
                ;
    }
    
    /**
     * @return PeriodService
     */
    protected function getPeriodService()
    {
        return $this->container->get('pequiven_seip.service.period');
    }
    
    /**
     * 
     * @return \Symfony\Component\HttpFoundation\Request
     */
    private function getRequest()
    {
        return $this->container->get('request_stack')->getCurrentRequest();
    }
}
