<?php

namespace Pequiven\SEIPBundle\Repository\sip\Cutl;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Repositorio de CUTL
 * @author Maximo Sojo maxsojo13@gmail.com
 *
 */
class CutlRepository extends EntityRepository {
  
   /**
     * Crea un paginador para los CUTL
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function createPaginatorByCutl(array $criteria = null, array $orderBy = null) {
        $orderBy['ct.nombre'] = 'ASC';
        return $this->createPaginator($criteria, $orderBy);
    }

   protected function getAlias() {
        return "ct";
   }  
}
