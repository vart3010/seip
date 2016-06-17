<?php

namespace Pequiven\SEIPBundle\Repository\Sip;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Repositorio de REP
 * @author Victor Tortolero vart10.30@gmail.com
 */
class RepRepository extends EntityRepository {
    
    /**
     *
     *
     *
     */
    public function getPqvCentro($codCentro){
        
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT *
            FROM sip_onePerTen AS o
            INNER JOIN sip_rep AS sp ON o.cedula = sp.cedula
            WHERE sp.codigoCentro ='.$codCentro;            

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
    public function getCentroPqv($codCentro) {
        
        $query = $this->getQueryBuilder();

        $query->select("rep")                
                //->innerJoin('rep.cedula', 'u')                
                ->andWhere('rep.codigoCentro = :codCentro')
                //->andWhere('rep.cedula = :cedula')
                //->setParameter('cedula', 152147)
                ->setParameter('codCentro', $codCentro)                
        ;

        $q = $query->getQuery();

        return $q->getResult();
    }

    protected function getAlias() {
        return "rep";
    }
}
