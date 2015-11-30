<?php

namespace Pequiven\SEIPBundle\Repository\Sip\Centro;

use Pequiven\SEIPBundle\Entity\Sip\Centro\Observations;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Repositorio observaciones
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
class ObservationsRepository extends EntityRepository {    
   
     /**
     * Crea un paginador para los Requerimientos
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function createPaginatorByRequest(array $criteria = null, array $orderBy = null) {
        return $this->createPaginator($criteria, $orderBy);
    }

    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);

        if (($codigoCentro = $criteria->remove('codigoCentro'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('obs.codigoCentro', "'%" . $codigoCentro . "%'"));
        }

        if (($observations = $criteria->remove('observations'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('obs.observations', "'%" . $observations . "%'"));
        }

        if (($fecha = $criteria->remove('fecha'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('obs.fecha', "'%" . $fecha . "%'"));
        }

        if (($centro = $criteria->remove('centro'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('obs.centro', "'%" . $centro . "%'"));
        }
        
        if (($parroquia = $criteria->remove('parroquia'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('obs.parroquia', "'%" . $parroquia . "%'"));
        }

        if (($municipio = $criteria->remove('municipio'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('obs.municipio', "'%" . $municipio . "%'"));
        }

        if (($estado = $criteria->remove('estado'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('obs.estado', "'%" . $estado . "%'"));
        }
        
        parent::applyCriteria($queryBuilder, $criteria->toArray());
    }

    protected function getAlias() {
        return "obs";
    }  
}