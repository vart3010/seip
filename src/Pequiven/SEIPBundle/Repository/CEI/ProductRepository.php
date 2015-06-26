<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Repository\CEI;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;
use Pequiven\SEIPBundle\Entity\CEI\Product;

/**
 * Repositorio de los productos
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ProductRepository extends SeipEntityRepository
{
    /**
     * Retorna query builder de los componentes activos
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryAllComponents()
    {
        $qb = $this->getQueryAllEnabled();
        $qb
            ->andWhere('p.typeOf = :typeOf')
            ->setParameter('typeOf', Product::TYPE_PRODUCT)
            ;
        return $qb;
    }
    public function findQueryByPlant($plant) 
    {
        $qb = $this->getQueryAllEnabled();
        $qb
            ->innerJoin("p.plants", "p_p")
            ->andWhere("p_p.id = :plant")
            ->setParameter("plant", $plant)
            ;
        return $qb;
    }
    
    public function findByPlant($plant) 
    {
        return $this->findQueryByPlant($plant)->getQuery()->getResult();
        
    }
    public function findByPlantReport($plantReport) 
    {
        $qb = $this->getQueryAllEnabled();
        $qb
            ->innerJoin("p.productReports", "p_pr")
            ->innerJoin("p_pr.plantReport", "p_pr_pr")
            ->andWhere("p_pr_pr.id = :plantReport")
            ->setParameter("plantReport", $plantReport)
            ;
        return $qb->getQuery()->getResult();
        
    }
    
    public function findIn($products)
    {
        $productsId = array();
        foreach ($products as $product) {
            $productsId[] = $product->getId();
        }
        $qb = $this->getQueryAllEnabled();
        $qb->andWhere($qb->expr()->in("p.id", $productsId));
        return $qb;
    }
    
    protected function getAlias() 
    {
        return 'p';
    }
}
