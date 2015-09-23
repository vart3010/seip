<?php

namespace Pequiven\IndicatorBundle\Repository\Indicator\EvolutionIndicator;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de las freuencias de notificación de los indicadores
 */
class EvolutionTrendRepository extends SeipEntityRepository {

    protected function getAlias() {
        return 'et';
    }

}