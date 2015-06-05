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
use Pequiven\SEIPBundle\Entity\CEI\Company;

/**
 * Repositorio de la compañia
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class CompanyRepository extends SeipEntityRepository
{
    public function getQueryNotMe(Company $company)
    {
        $qb = $this->getQueryAllEnabled();
        $qb
            ->andWhere("c.id != :company")
            ->setParameter("company", $company);
        return $qb;
    }
    
    public function findSearch(array $criteria, $options = array()) 
    {
        return parent::findSearch($criteria, array('property' => 'description'));
    }
    
    protected function getAlias() 
    {
        return "c";
    }
}
