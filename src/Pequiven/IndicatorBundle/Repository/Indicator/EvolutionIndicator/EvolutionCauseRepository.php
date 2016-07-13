<?php

namespace Pequiven\IndicatorBundle\Repository\Indicator\EvolutionIndicator;


use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de las freuencias de notificación de los indicadores
 */
class EvolutionCauseRepository extends SeipEntityRepository {


    function getCausesByObject($id, $typeObject) {
        
        $queryBuilder = $this->getQueryBuilder();

        $queryBuilder
                ->addSelect('ec')                
                ->where('ec.idObject = :id')
                ->andWhere('ec.typeObject = :typeObj')
                ->orderBy('ec.causes')
                ->setParameter('id', $id)
                ->setParameter('typeObj', $typeObject)
        ;        
        
        return $queryBuilder;
    }

    /**
     * Retornar las causas consultadas
     * @return type
     */
    function findToValidToCausesEvolution(array $causes = array(), array $criteria = array()) {
        return $this->findQueryToCauses($causes, $criteria)->getQuery()->getResult();
    }

    /**
     *
     *
     */
    public function findQueryToCauses(array $causes, array $criteria = array()){        
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);        
        $qb = $this->getQueryBuilder();

        $orX = $qb->expr()->orX();        
        if (($cause = $criteria->remove('causes'))) {            
            $orX->add($qb->expr()->like('ec.causes', "'%" . $cause . "%'"));
        }
        if (($id = $criteria->remove('id'))) {            
            $orX->add($qb->expr()->like('ec.id', "'%" . $id . "%'"));
        }

        $qb->andWhere($orX);

        $qb->setMaxResults(30);        
        
        return $qb;
    }

    protected function getAlias() {
        return 'ec';
    }
}