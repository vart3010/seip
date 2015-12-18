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
    function findResultByMesas($codigoCentro) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT m.*
        FROM datosMesa AS m
        WHERE m.centro = '.$codigoCentro.'
        ORDER BY m.centro,m.mesa ASC,m.porc DESC';

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
    function findByNotification($id) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT o.notification
            FROM sip_centro_report_observations AS o 
            WHERE o.report_id ='.$id.' AND o.deletedAt IS NULL
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
    function findByEstadoOtrosRes() {
        
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
    function findByEstadoData($estado) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT
                    Estado,
                      SUM(votoSI),
                    SUM(votoNO)   
                FROM
                    General_Votes
                WHERE
                    Estado = "'.$estado.'" AND Tipo = "PQV"
                GROUP BY Estado';            

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
                    Estado,
                      SUM(votoSI),
                    SUM(votoNO)   
                FROM
                    General_Votes
                WHERE
                    Estado not in ("EDO. CARABOBO", "EDO. ZULIA", "EDO. ANZOATEGUI")
                GROUP BY Estado';            

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
    function findByMunicipioOtros() {
        
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
                    Estado,
                    Tipo,
                      SUM(votoSI),
                    SUM(votoNO)   
                FROM
                    General_Votes 
                WHERE Tipo = "PQV"               
                GROUP BY Tipo';            

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
                    Estado,
                    Tipo,
                      SUM(votoSI),
                    SUM(votoNO)   
                FROM
                    General_Votes 
                WHERE Tipo = "1x10"               
                GROUP BY Tipo';            

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
                    Estado,
                    Tipo,
                      SUM(votoSI),
                    SUM(votoNO)   
                FROM
                    General_Votes
                WHERE
                     Estado ="'.$estado.'" AND Tipo = "1x10"
                GROUP BY Estado';            

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
    function findByEstadoMembersEdoOtros() {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT
                    Estado,
                    Tipo,
                      SUM(votoSI),
                    SUM(votoNO)   
                FROM
                    General_Votes
                WHERE
                     Estado not in ("EDO. CARABOBO", "EDO. ZULIA", "EDO. ANZOATEGUI") AND Tipo = "1x10"
                GROUP BY Estado';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    } 

    /**
     * Consulta de Municipios
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
                WHERE c.codigoEstado ="'.$estado.'"
                GROUP BY descriptionMunicipio';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }

        /**
     * Consulta de Municipios
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByMunicipioName($estado, $mcpo) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT c.descriptionMunicipio
                FROM
                sip_centro AS c            
                WHERE c.codigoEstado ="'.$estado.'" AND c.codigoMunicipio ="'.$mcpo.'"
                GROUP BY descriptionMunicipio';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }

    /**
     * Consulta de Parroquias
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByParroquias($estado, $mcpo) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT c.descriptionParroquia,c.codigoParroquia
                FROM
                sip_centro AS c            
                WHERE c.codigoEstado ="'.$estado.'" AND c.codigoMunicipio ="'.$mcpo.'"
                GROUP BY descriptionParroquia';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }

    /**
     * Votos por municipio de PQV
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByVotosMunicipios($mcpo,$estado) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT
                    Municipio,
                      SUM(votoSI),
                    SUM(votoNO)   
                FROM
                    General_Votes
                WHERE
                    Estado ="'.$estado.'" AND Municipio = "'.$mcpo.'" AND Tipo = "PQV"
                GROUP BY Municipio';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }

    /**
     * Votos por municipio de General
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByVotosMunicipiosGeneral($mcpo,$estado) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT
                    Municipio,
                      SUM(votoSI),
                    SUM(votoNO)   
                FROM
                    General_Votes
                WHERE
                    Estado ="'.$estado.'" AND Municipio = "'.$mcpo.'" AND Tipo = "1x10"
                GROUP BY Municipio';

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
                    Municipio,
                      SUM(votoSI),
                    SUM(votoNO)   
                FROM
                    General_Votes
                WHERE
                    Estado ="'.$estado.'" AND Municipio = "'.$mcpo.'" AND Tipo = "PQV"
                GROUP BY Municipio';            

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
    function findByVotosMunicipiosIdGeneral($estado, $mcpo) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT
                    Municipio,
                      SUM(votoSI),
                    SUM(votoNO)   
                FROM
                    General_Votes
                WHERE
                    Estado ="'.$estado.'" AND Municipio = "'.$mcpo.'" AND Tipo = "1x10"
                GROUP BY Municipio';            

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
    function findByVotosMunicipiosCant($estado, $mcpo, $type) {

        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql1 = 'SELECT
                    Municipio,
                      SUM(votoSI),
                    SUM(votoNO)   
                FROM
                    General_Votes
                WHERE
                    Estado ="'.$estado.'" AND Municipio = "'.$mcpo.'"';       
        
        if ($type == 2) {
            $sql2 = ' AND Tipo = "PQV"';            
        }else{
            $sql2 = "";
        }

        $sql3 = ' GROUP BY Municipio';

        $sql = $sql1.$sql2.$sql3;

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
    function findByVotosParroquia($parroquia,$estado) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT
                    Parroquia,
                      SUM(votoSI),
                    SUM(votoNO)   
                FROM
                    General_Votes
                WHERE
                    Estado ="'.$estado.'" AND Parroquia = "'.$parroquia.'" AND Tipo = "PQV"
                GROUP BY Parroquia';            

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
    function findByVotosParroquiaGeneral($parroquia,$estado) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT
                    Parroquia,
                      SUM(votoSI),
                    SUM(votoNO)   
                FROM
                    General_Votes
                WHERE
                    Estado ="'.$estado.'" AND Parroquia = "'.$parroquia.'" AND Tipo = "1x10"
                GROUP BY Parroquia';            

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
                GROUP BY c.codigoMunicipio';            

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
     * Votos PQV MORON Y SEDE
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByLocalidad($localidad) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT
                    Localidad,
                      SUM(votoSI),
                    SUM(votoNO)   
                FROM
                    General_Votes
                WHERE
                    Localidad ="'.$localidad.'" AND Tipo = "PQV"
                GROUP BY Localidad';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }

    /**
     * Votos por 1X10 PQV
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByLocalidad1x10($localidad) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT
                    Localidad,
                      SUM(votoSI),
                    SUM(votoNO)   
                FROM
                    General_Votes
                WHERE
                    Localidad ="'.$localidad.'" AND Tipo = "1x10"
                GROUP BY Localidad';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }

    /**
     * Votos PQV CIRCUITO 5
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByCircuito5Edo($estado) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT
                    Estado,
                      SUM(votoSI),
                    SUM(votoNO)   
                FROM
                    General_Votes
                WHERE
                    Estado ="'.$estado.'" AND Tipo = "PQV" AND Parroquia in ("PQ. U TOCUYITO", "PQ. U INDEPENDENCIA", 
                        "PQ. MIGUEL PEÑA", "PQ. RAFAEL URDANETA", "PQ. NEGRO PRIMERO", "PQ. SANTA ROSA")
                GROUP BY Estado';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }

    /**
     * Votos PQV CIRCUITO5 1X10
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByCircuito5Edo1x10($estado) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT
                    Estado,
                      SUM(votoSI),
                    SUM(votoNO)   
                FROM
                    General_Votes
                WHERE
                    Estado ="'.$estado.'" AND Tipo = "1x10" AND Parroquia in ("PQ. U TOCUYITO", "PQ. U INDEPENDENCIA", 
                        "PQ. MIGUEL PEÑA", "PQ. RAFAEL URDANETA", "PQ. NEGRO PRIMERO", "PQ. SANTA ROSA")
                GROUP BY Estado';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }

    /**
     * Votos PQV CIRCUITO5 Barra
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByCircuito5Barra($estado, $parroquia,$tipo) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT
                    Parroquia,
                      SUM(votoSI),
                    SUM(votoNO)   
                FROM
                    General_Votes
                WHERE
                    Estado ="'.$estado.'" AND Tipo = "'.$tipo.'" AND Parroquia = "'.$parroquia.'"
                GROUP BY Parroquia';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }

    /**
     * Votos 1x10
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findBy1x10() {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT
                    Tipo,
                      SUM(votoSI),
                    SUM(votoNO)   
                FROM
                    General_Votes
                WHERE
                    Tipo ="1x10"
                GROUP BY Tipo';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }

    /**
     * Votos 1x10 por estado
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByBarra1x10($estado) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT
                    Tipo,
                      SUM(votoSI),
                    SUM(votoNO)   
                FROM
                    General_Votes
                WHERE
                    Tipo ="1x10" AND Estado = "'.$estado.'"
                GROUP BY Tipo';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }

    /**
     * Votos 1x10 por estado
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByBarra1x10Otros() {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT
                    Tipo,
                      SUM(votoSI),
                    SUM(votoNO)   
                FROM
                    General_Votes
                WHERE
                    Tipo ="1x10" AND Estado not in ("EDO. CARABOBO", "EDO. ZULIA", "EDO. ANZOATEGUI")
                GROUP BY Tipo';            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }

    /**
     * Votos Horas
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByGeneralHoras($type) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql1 = 'SELECT
                    HOUR(Fecha) AS Hora,
                    SUM(VotoSI) AS Si
                FROM
                    General_Votes
                WHERE                    
                    VotoSI=1 AND Fecha is not null';

        if($type == 2) {
            $sql2 = ' AND Tipo = "PQV"';
        }elseif($type == 3){
            $sql2 = ' AND Estado = "EDO. CARABOBO" AND Parroquia in ("PQ. U TOCUYITO", "PQ. U INDEPENDENCIA", 
                        "PQ. MIGUEL PEÑA", "PQ. RAFAEL URDANETA", "PQ. NEGRO PRIMERO", "PQ. SANTA ROSA")';
        }elseif($type == 4){
            $sql2 = ' AND Tipo = "1x10"';
        }elseif($type == 5){
            $sql2 = ' AND Estado = "'.$estado.'"';
        }else{
            $sql2 = '';
        };

        $sql3 = ' GROUP BY Hora
                ORDER BY Hora';            
                
        $sql = $sql1.$sql2.$sql3;

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }


    /**
     * Votos Horas
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByGeneralHorasEstado($type,$estado) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql1 = 'SELECT
                    HOUR(Fecha) AS Hora,
                    SUM(VotoSI) AS Si
                FROM
                    General_Votes
                WHERE                    
                    VotoSI=1 AND Fecha is not null';

        if($type == 2) {
            $sql2 = ' AND Tipo = "PQV"';
        }elseif($type == 3){
            $sql2 = ' AND Estado = "EDO. CARABOBO" AND Parroquia in ("PQ. U TOCUYITO", "PQ. U INDEPENDENCIA", 
                        "PQ. MIGUEL PEÑA", "PQ. RAFAEL URDANETA", "PQ. NEGRO PRIMERO", "PQ. SANTA ROSA")';
        }elseif($type == 4){
            $sql2 = ' AND Tipo = "1x10"';
        }elseif($type == 5){
            $sql2 = ' AND Estado = "'.$estado.'"';
        }else{
            $sql2 = '';
        };

        $sql3 = ' GROUP BY Hora
                ORDER BY Hora';            
                
        $sql = $sql1.$sql2.$sql3;

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }

    /**
     * Votos Horas
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function findByGeneralHorasMcpo($type,$estado,$mcpo) {
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql1 = 'SELECT
                    HOUR(Fecha) AS Hora,
                    SUM(VotoSI) AS Si
                FROM
                    General_Votes
                WHERE                    
                    VotoSI=1 AND Estado = "'.$estado.'" AND Municipio ="'.$mcpo.'" AND Fecha is not null';
        
        if ($type == 2) {
            $sql2 = ' AND Tipo = "PQV"';
        }else{
            $sql2 = "";
        }
        
        $sql3 = ' GROUP BY Hora
                ORDER BY Hora';
        
        $sql = $sql1.$sql2.$sql3;

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
        
        $queryBuilder->andWhere('(ctro.codigoEstado = 7) OR (ctro.codigoEstado = 21) OR (ctro.codigoEstado = 2)');
                //->setParameter('circuito', 5);
        
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
