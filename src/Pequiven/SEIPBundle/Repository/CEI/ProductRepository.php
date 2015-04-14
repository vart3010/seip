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
    
    protected function getAlias() 
    {
        return 'p';
    }
}
