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
 * Description of SeipEntityRepository
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class SeipEntityRepository extends EntityRepository
{
    public function getQueryAllEnabled()
    {
        $qb = $this->getQueryBuilder();
        $qb
            ->andWhere($this->getAlias().'.enabled = :enabled')
            ->setParameter('enabled', true)
            ;
        return $qb;
    }
    
    public function getAllEnabled()
    {
        $qb = $this->getQueryAllEnabled();
        return $qb->getQuery()->getResult();
    }


    protected function applyPeriodCriteria(QueryBuilder &$queryBuilder, $alias = null) 
    {
        if($alias === null){
            $alias = $this->getAlias();
        }
        
        $queryBuilder->andWhere($alias.'.period = :period');
        $this->setParameterPeriod($queryBuilder);
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
        return $this->container->get('pequiven_arrangement_program.service.period');
    }
}
