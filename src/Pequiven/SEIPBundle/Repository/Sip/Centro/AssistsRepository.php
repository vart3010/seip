<?php

namespace Pequiven\SEIPBundle\Repository\Sip\Centro;

use Pequiven\SEIPBundle\Entity\Sip\Centro\Assists;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Repositorio asistencia
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
class AssistsRepository extends EntityRepository {    
   	
   	/**
     *
     *
     *
     */
    public function getAssistFecha($codCentro, $fecha){
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();
        
        $sql = "SELECT *
            FROM sip_centro_assists AS ast
            WHERE ast.fecha LIKE '%".$fecha."%' AND ast.deletedAt IS NULL AND ast.codigoCentro =".$codCentro ;            

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;

    }

    /**
     *
     *
     *
     */
    public function getAssistFechaCenter($codCentro, $fecha){
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();
        
        $sql = "SELECT *
            FROM sip_centro_status AS ast
            WHERE ast.fecha LIKE '%".$fecha."%' AND ast.deletedAt IS NULL AND ast.codigoCentro =".$codCentro ;                    

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;

    }

    protected function getAlias() {
        return "ast";
    }  
}
