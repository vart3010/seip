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
            $queryBuilder->andWhere($queryBuilder->expr()->like("rt.name","'%".$name."%'"));        }
        
        return parent::applyCriteria($queryBuilder, $criteria->toArray());
    }
    
    protected function getAlias() {
        return "rt";
    }
}
