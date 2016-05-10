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
/**
 * Repositorio de la sede
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class LocationRepository extends SeipEntityRepository
{
    public function findByCompany($company) 
    {
        $qb = $this->getQueryAllEnabled();
        $qb
            ->andWhere("l.company = :company")
            ->setParameter("company", $company)
            ;
        return $qb->getQuery()->getResult();
        
    }
    
    public function findByCodeTypeLocation($codeTypeLocation)
    {
        $qb = $this->getQueryAllEnabled();
        $qb
            ->innerJoin("l.company","l_c")
            ->innerJoin("l.typeLocation","l_tl")
            ->andWhere("l_tl.code = :code")
            ->setParameter("code", $codeTypeLocation)
            ;
        return $qb->getQuery()->getResult();
    }
    
    protected function getAlias() 
    {
        return "l";
    }
}