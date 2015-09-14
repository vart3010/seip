<?php

namespace Pequiven\IndicatorBundle\Repository\Indicator\EvolutionIndicator;


use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de las freuencias de notificación de los indicadores
 */
class EvolutionCauseRepository extends SeipEntityRepository {


    function getCausesByIndicator(indicator $indicator) {
        //Chuleta: se necesita el id del period, no la descripcion.
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder

                ->addSelect('ec')                
                ->where('ec.indicator = :indic')
                ->orderBy('ec.causes')
                ->setParameter('indic', $indicator)
        ;
        
        return $queryBuilder;
    }

    protected function getAlias() {
        return 'ec';
    }
}