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

use Tecnocreaciones\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * Description of SeipEntityRepository
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class SeipEntityRepository extends EntityRepository
{
    protected function applyPeriodCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, $alias = null) 
    {
        if($alias === null){
            $alias = $this->getAlias();
        }
        $periodService = $this->getPeriodService();
        $queryBuilder
                ->andWhere($alias.'.period = :period')
                ->setParameter('period', $periodService->getPeriodActive())
                ;
    }
    /**
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService()
    {
        return $this->container->get('pequiven_arrangement_program.service.period');
    }
}
