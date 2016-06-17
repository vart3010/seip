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
 * Repositorio de servicio
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ServiceRepository extends SeipEntityRepository
{
    /**
     * Retorna una constructora de consulta de buscar por planta
     * @param type $plant
     * @return type
     */
    public function findQueryByPlant($plant) 
    {
        $qb = $this->getQueryAllEnabled();
        $qb
            ->innerJoin("s.plants","s_p")
            ->andWhere("s_p.id = :plant")
            ->setParameter("plant", $plant)
            ;
        return $qb;
    }
    
    protected function getAlias() {
        return "s";
    }
}
