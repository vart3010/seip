<?php

namespace Pequiven\SIGBundle\Repository;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de sistema de gestión (pequiven.repository.sig_management_system)
 *
 */
class ManagementSystemRepository extends SeipEntityRepository
{
	/**
     * Crea un paginador para los sistemas de la calidad para la matriz
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function createPaginatorManagementSystems(array $criteria = null, array $orderBy = null) {
       
        $orderBy['ms.id'] = 'ASC';
        
        return $this->createPaginator($criteria, $orderBy);
    }

    protected function getAlias() {
        return 'ms';
    }
}
