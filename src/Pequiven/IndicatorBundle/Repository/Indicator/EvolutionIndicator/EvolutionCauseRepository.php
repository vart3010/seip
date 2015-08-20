<?php

namespace Pequiven\IndicatorBundle\Repository\Indicator\EvolutionIndicator;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de las freuencias de notificación de los indicadores
 */
class EvolutionCauseRepository extends SeipEntityRepository {

    protected function getAlias() {
        return 'ec';
    }

}