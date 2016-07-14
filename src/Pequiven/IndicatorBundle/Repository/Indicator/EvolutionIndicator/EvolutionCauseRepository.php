<?php

namespace Pequiven\IndicatorBundle\Repository\Indicator\EvolutionIndicator;


use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCause;
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
    function findToValidToCausesEvolution(array $dataCauses = array(), array $criteria = array(), $idObject, $month, $typeObject) {
        return $this->findQueryToCauses($dataCauses, $criteria, $idObject, $month, $typeObject)->getQuery()->getResult();
    }

    /**
     *
     *
     */
    public function findQueryToCauses(array $dataCauses, array $criteria = array(), $idObject, $month, $typeObject){        
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);        
        //$queryBuilder = $this->getCollectionQueryBuilder();
        $qb = $this->getQueryBuilder();        
        $qb
                    ->andWhere('ec.idObject = :idObject')
                    ->andWhere('ec.typeObject = :typeObj')
                    ->andWhere('ec.month = :month')
                    ->setParameter('month', $month)
                    ->setParameter('idObject', $idObject)
                    ->setParameter('typeObj', $typeObject)
        ;        

        $orX = $qb->expr()->orX();        
        if (($cause = $criteria->remove('causes'))) {            
            $orX->add($qb->expr()->like('ec.causes', "'%" . $cause . "%'"));
        }

        $qb->andWhere($orX);

        $qb->setMaxResults(50);        
        
        return $qb;
    }

    protected function getAlias() {
        return 'ec';
    }
}