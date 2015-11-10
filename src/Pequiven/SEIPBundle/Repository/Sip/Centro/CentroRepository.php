<?php

namespace Pequiven\SEIPBundle\Repository\Sip\Centro;

use Pequiven\SEIPBundle\Entity\Sip\Centro;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Repositorio de Centro
 *
 */
class CentroRepository extends EntityRepository {
  
   /**
     * Crea un paginador para los CUTL
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function createPaginatorByCentro(array $criteria = null, array $orderBy = null) {
        return $this->createPaginator($criteria, $orderBy);
    }
    
    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        
        if (($nombreCentro = $criteria->remove('centro'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('ctro.description', "'%".$nombreCentro."%'"));
        }
        
        if (($codigoCentro = $criteria->remove('codigoCentro'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('ctro.codigoCentro', "'%".$codigoCentro."%'"));
        }
        
        if (($municipio = $criteria->remove('municipio'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('ctro.descriptionMunicipio', "'%".$municipio."%'"));
        }
        
        if (($parroquia = $criteria->remove('parroquia'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('ctro.descriptionParroquia', "'%".$parroquia."%'"));
        }
        
        parent::applyCriteria($queryBuilder, $criteria->toArray());
    }
   
    protected function getAlias() {
        return "ctro";
    }  
}
