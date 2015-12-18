<?php

namespace Pequiven\SEIPBundle\Repository\Sip\Centro;

use Pequiven\SEIPBundle\Entity\Sip\Center\Material;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Repositorio asistencia
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
class MaterialRepository extends EntityRepository {  

	/**
     * Retorna solo los materiales activos
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findQuerySipMaterial() {

        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder
                ->select('mat')
                ->andWhere('mat.enabled = 1')
                ->andWhere('mat.deletedAt IS NULL')                
            ;

        return $queryBuilder;
    }  
   
    protected function getAlias() {
        return "mat";
    }  
}