<?php

namespace Pequiven\SEIPBundle\Repository\Sip;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * 
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
class NominaCentroRepository extends EntityRepository {

	/**
     * Crea un paginador para los Votantes de Personal PQV
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function createPaginatorByCentroPqv(array $criteria = null, array $orderBy = null) {
        return $this->createPaginator($criteria, $orderBy);
    }
    
	/**
     * Crea un paginador para los Votantes de Personal PQV
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function createPaginatorByCentroWithVotePqv(array $criteria = null, array $orderBy = null) {
        return $this->createPaginator($criteria, $orderBy);
    }

    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);

        if(($codCentro = $criteria->remove('codCentro'))){                        	
            	$queryBuilder
                    ->andWhere('nc.codigoCentro = :codCentro')
                    ->setParameter('codCentro', $codCentro)
                ;        	
        }
        if (($cedula = $criteria->remove('cedula'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('nc.cedula', "'%" . $cedula . "%'"));
        }
        
        if (($voto = $criteria->remove('voto'))) {
            $numVoto = 0;
            if($voto == 'SI'){
                $numVoto = 1;
            }
            $queryBuilder->andWhere('nc.voto = '.$numVoto);
        }

        if (($nombre = $criteria->remove('nombre'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('nc.nombre', "'%" . $nombre . "%'"));
        }

        if (($telefono = $criteria->remove('telefono'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('nc.telefono', "'%" . $telefono . "%'"));
        }

        if (($centro = $criteria->remove('centro'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('nc.centro', "'%" . $centro . "%'"));
        }

        if (($codigoCentro = $criteria->remove('codigoCentro'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('nc.codigoCentro', "'%" . $codigoCentro . "%'"));
        }
        
        if (($localidad = $criteria->remove('localidad'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('nc.localidad', "'%" . $localidad . "%'"));
        }
        
        parent::applyCriteria($queryBuilder, $criteria->toArray());
    }

    protected function getAlias() {
        return "nc";
    }

}
