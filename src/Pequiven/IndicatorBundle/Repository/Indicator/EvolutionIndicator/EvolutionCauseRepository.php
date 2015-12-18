<?php

namespace Pequiven\IndicatorBundle\Repository\Indicator\EvolutionIndicator;


use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de las freuencias de notificación de los indicadores
 */
class EvolutionCauseRepository extends SeipEntityRepository {


    function getCausesByIndicator($id, $typeObject) {
        
        $queryBuilder = $this->getQueryBuilder();

        if ($typeObject == 1) {            
            $queryBuilder

                    ->addSelect('ec')                
                    ->where('ec.indicator = :indic')
                    ->orderBy('ec.causes')
                    ->setParameter('indic', $id)
            ;        
        }elseif ($typeObject == 2) {
            $queryBuilder

                    ->addSelect('ec')                
                    ->where('ec.arrangementProgram = :arrangement')
                    ->orderBy('ec.causes')
                    ->setParameter('arrangement', $id)
            ;        
        }

        return $queryBuilder;
    }

    protected function getAlias() {
        return 'ec';
    }
}