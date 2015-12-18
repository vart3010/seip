<?php

namespace Pequiven\SEIPBundle\Repository\sip\Cutl;

use Pequiven\SEIPBundle\Entity\Sip\Cutl;
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
        return $this->createPaginator($criteria, $orderBy);
    }

    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);

        if (($nombreCentro = $criteria->remove('centro'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('ct.centro', "'%" . $nombreCentro . "%'"));
        }

        if (($codigoCentro = $criteria->remove('codigoCentro'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('ct.codigoCentro', "'%" . $codigoCentro . "%'"));
        }

        if (($nombrePersona = $criteria->remove('nombre'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('ct.nombre', "'%" . $nombrePersona . "%'"));
        }

        if (($cedulaPersona = $criteria->remove('cedula'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('ct.cedula', "'%" . $cedulaPersona . "%'"));
        }

        if (($municipio = $criteria->remove('municipio'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('ct.municipio', "'%" . $municipio . "%'"));
        }

        if (($parroquia = $criteria->remove('parroquia'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('ct.parroquia', "'%" . $parroquia . "%'"));
        }

        parent::applyCriteria($queryBuilder, $criteria->toArray());
    }
    
    public function getCutlData($cedula) {

        $query = $this->getQueryBuilder();

        $query
                ->andWhere('ct.cedula = :ced')
                ->setParameter("ced", $cedula)
        ;

        $q = $query->getQuery();

        return $q->getResult();
    }

    protected function getAlias() {
        return "ct";
    }

}
