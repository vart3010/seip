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
     * 
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByVoto($id) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT o.votos
            FROM sip_centro_report_voto AS o            
            WHERE o.centro_id ='.$id.'
            order by id desc limit 1';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }  

    /**
     * 
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByEstadoOtros() {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT 
                CASE
                    WHEN ((oxp.voto = 0) OR (oxp.voto IS NULL)) THEN "No"
                    ELSE "Si"
                END AS Voto,
                COUNT(oxp.voto) AS Cant
                FROM
                    sip_onePerTen AS oxp
                        INNER JOIN
                    sip_nomina_centro AS nom ON (oxp.cedula = nom.Cedula) 
                    where nom.descriptionEstado not in ("EDO. CARABOBO", "EDO. ZULIA", "EDO. ANZOATEGUI")                   
                GROUP BY voto';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    } 

    /**
     * 
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByEstado() {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT 
                CASE
                    WHEN ((oxp.voto = 0) OR (oxp.voto IS NULL)) THEN "No"
                    ELSE "Si"
                END AS Voto,
                COUNT(oxp.voto) AS Cant
                FROM
                    sip_onePerTen AS oxp
                        INNER JOIN
                    sip_nomina_centro AS nom ON (oxp.cedula = nom.Cedula)                                        
                GROUP BY voto';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }

    /**
     * 
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByEstadoData($estado) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT 
                CASE
                    WHEN ((oxp.voto = 0) OR (oxp.voto IS NULL)) THEN "No"
                    ELSE "Si"
                END AS Voto,
                COUNT(oxp.voto) AS Cant
                FROM
                    sip_onePerTen AS oxp
                        INNER JOIN
                    sip_nomina_centro AS nom ON (oxp.cedula = nom.Cedula) 
                    where nom.descriptionEstado ="'.$estado.'"                   
                GROUP BY voto';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }

    /**
     * 
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByEstadoMembers() {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT
                case when voto=0 then "No"
                else "Si" end as Voto
                , COUNT(oxp.voto) AS Cant
                FROM
                    sip_onePerTenMembers AS oxp                    
                GROUP BY voto';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }

    /**
     * 
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByEstadoMembersEdo($estado) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT
                case when voto=0 then "No"
                else "Si" end as Voto
                , COUNT(oxp.voto) AS Cant
                FROM
                    sip_onePerTenMembers AS oxp                    
                WHERE oxp.nombreEstado ="'.$estado.'"
                GROUP BY voto';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    } 

    /**
     * 
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByMunicipios($estado) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT c.descriptionMunicipio
                FROM
                sip_centro AS c            
                WHERE c.descriptionEstado ="'.$estado.'"
                GROUP BY descriptionMunicipio';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }

    /**
     * 
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByVotosMunicipios($mcpo,$estado) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT 
                CASE
                    WHEN ((oxp.voto = 0) OR (oxp.voto IS NULL)) THEN "No"
                    ELSE "Si"
                END AS Voto,
                COUNT(oxp.voto) AS Cant
                FROM
                    sip_onePerTen AS oxp
                        INNER JOIN
                    sip_nomina_centro AS nom ON (oxp.cedula = nom.cedula) 
                    where nom.descriptionMunicipio = "'.$mcpo.'" AND nom.descriptionEstado  ="'.$estado.'"
                GROUP BY voto';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }

    /**
     * Consulta de votos por Municipios
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByVotosMunicipiosId($estado, $mcpo) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT 
                CASE
                    WHEN ((oxp.voto = 0) OR (oxp.voto IS NULL)) THEN "No"
                    ELSE "Si"
                END AS Voto,
                COUNT(oxp.voto) AS Cant
                FROM
                    sip_onePerTen AS oxp
                        INNER JOIN
                    sip_nomina_centro AS nom ON (oxp.cedula = nom.cedula) 
                    where nom.descriptionMunicipio = "'.$mcpo.'" AND nom.descriptionEstado  ="'.$estado.'"
                GROUP BY voto';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }

    /**
     * 
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByVotosParroquia($mcpo,$estado) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT 
                CASE
                    WHEN ((oxp.voto = 0) OR (oxp.voto IS NULL)) THEN "No"
                    ELSE "Si"
                END AS Voto,
                COUNT(oxp.voto) AS Cant
                FROM
                    sip_onePerTen AS oxp
                        INNER JOIN
                    sip_nomina_centro AS nom ON (oxp.cedula = nom.cedula) 
                    where nom.descriptionMunicipio = "'.$mcpo.'" AND nom.descriptionEstado  ="'.$estado.'"
                GROUP BY voto';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }

    /**
     * Retorna Codigo de Municipio
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByMcpoId($municipio, $estado) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT c.codigoMunicipio AS id               
                FROM
                    sip_centro AS c                   
                    where c.descriptionMunicipio = "'.$municipio.'" AND c.codigoEstado  ="'.$estado.'"
                GROUP BY id';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }

    /**
     * Retorna Descripcion de Estado y Municipio
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByMcpoAndEdoId($estado, $municipio) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT c.descriptionEstado AS edo, c.descriptionMunicipio AS mcpo               
                FROM
                    sip_centro AS c                   
                    where c.codigoMunicipio = "'.$municipio.'" AND c.codigoEstado  ="'.$estado.'"
                GROUP BY id';            

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
