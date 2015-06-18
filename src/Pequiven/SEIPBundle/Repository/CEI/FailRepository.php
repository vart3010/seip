<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Repository\CEI;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de falla
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class FailRepository extends SeipEntityRepository
{
    
    public function findQueryByTypeResult($typeFail){
        $queryBuilder = $this->findQueryByType($typeFail);
        return $queryBuilder->getQuery()->getResult();
    }
    
    /**
     * Tipo de falla
     * @param \Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_* $typeFail
     * @return type
     */
    
    public function findQueryByType($typeFail) 
    {
        $qb = $this->getQueryAllEnabled();
        $qb
            ->andWhere('f.typeFail = :typeFail')
            ->setParameter('typeFail', $typeFail)
            ;
        return $qb;
    }
    
   
    
    protected function getAlias() 
    {
        return 'f';
    }
}
