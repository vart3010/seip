<?php

namespace Pequiven\SEIPBundle\Repository\DataLoad\Production;

//use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Description of Chart(pequiven.repository.chart)
 *
 * @author victor tortolero
 */
class UnrealizedProductionDayRepository extends SeipEntityRepository {

    /**
     * 
     * @param type $typeFail
     * @return type
     */
    public function findQueryByTypeResult() {
        $queryBuilder = $this->findQueryByType();
        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * 
     * @param type $typeFail
     * @return type
     */
    public function findQueryByType() {
        $qb = $this->getQueryBuilder();
        //$em = $this->getEntityManager();
//        $query = $em->createQuery(""
//                . "SELECT count(up.id) "
//                . "FROM ".$this->_entityName." as up "
//                . "LEFT JOIN Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay\RawMaterialRequired upi "
//                . "WITH upi.rawmaterialrequired_id = up.id ");
//        
        //$query = $em->createQuery("SELECT up.id FROM ".$this->_entityName." as up");
        
        
        return $qb;
    }

}
