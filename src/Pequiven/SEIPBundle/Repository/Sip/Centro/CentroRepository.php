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
     * 
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByNotification($id) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT o.notification
            FROM sip_centro_report_observations AS o            
            WHERE o.report_id ='.$id.'
            order by id desc limit 1';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }  

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
            $queryBuilder->andWhere($queryBuilder->expr()->like('ctro.description', "'%" . $nombreCentro . "%'"));
        }

        if (($codigoCentro = $criteria->remove('codigoCentro'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('ctro.codigoCentro', "'%" . $codigoCentro . "%'"));
        }

        if (($estado = $criteria->remove('estado'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('ctro.descriptionEstado', "'%" . $estado . "%'"));
        }
        
        if (($municipio = $criteria->remove('municipio'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('ctro.descriptionMunicipio', "'%" . $municipio . "%'"));
        }

        if (($parroquia = $criteria->remove('parroquia'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('ctro.descriptionParroquia', "'%" . $parroquia . "%'"));
        }
        
        $queryBuilder->andWhere('(ctro.circuito = :circuito AND ctro.codigoEstado = 7) OR (ctro.codigoEstado = 21)')
                ->setParameter('circuito', 5);
        
        parent::applyCriteria($queryBuilder, $criteria->toArray());
    }

    public function getCentro($codCentro) {
        $query = $this->getQueryBuilder();

        $query->select("ctro.description")
                ->andWhere('ctro.codigoCentro = :codCentro')
                ->setParameter('codCentro', $codCentro);

        $q = $query->getQuery();

        return $q->getResult();
    }

    protected function getAlias() {
        return "ctro";
    }

}
