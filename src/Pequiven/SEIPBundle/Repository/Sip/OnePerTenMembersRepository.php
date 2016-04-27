<?php

namespace Pequiven\SEIPBundle\Repository\Sip;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Description of OnePErTenRepository
 *
 * @author Victor Tortolero vart10.30@gmail.com
 */
class OnePerTenMembersRepository extends EntityRepository {
    
    /**
     * Crea un paginador para los Votantes de Personal PQV
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function createPaginatorByCentroOptm(array $criteria = null, array $orderBy = null) {
        return $this->createPaginator($criteria, $orderBy);
    }
    
    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);

        if(($codCentro = $criteria->remove('codCentro'))){                        	
            	$queryBuilder
                    ->andWhere('optm.codCentro = :codCentro')
                    ->setParameter('codCentro', $codCentro)
                ;
        }
        if (($cedula = $criteria->remove('cedula'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('optm.cedula', "'%" . $cedula . "%'"));
        }
        
        if (($voto = $criteria->remove('voto'))) {
            $numVoto = 0;
            if($voto == 'SI'){
                $numVoto = 1;
            }
            $queryBuilder->andWhere('optm.voto = '.$numVoto);
        }

        if (($nombre = $criteria->remove('nombre'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('optm.nombre', "'%" . $nombre . "%'"));
        }

        if (($telefono = $criteria->remove('telefono'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('optm.telefono', "'%" . $telefono . "%'"));
        }

        if (($centro = $criteria->remove('centro'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('optm.nombreCentro', "'%" . $centro . "%'"));
        }

        if (($codigoCentro = $criteria->remove('codigoCentro'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('optm.codCentro', "'%" . $codigoCentro . "%'"));
        }
        
        parent::applyCriteria($queryBuilder, $criteria->toArray());
    }
    
        public function getOnePerTenVotoPeople($cedula) {

        $query = $this->getQueryBuilder();

        $query
                ->andWhere('optm.cedula = :ced')
                ->setParameter("ced", $cedula)
        ;

        $q = $query->getQuery();

        return $q->getResult();
    }

    
    //put your code here
    protected function getAlias() {
        return "optm";
    }
}
