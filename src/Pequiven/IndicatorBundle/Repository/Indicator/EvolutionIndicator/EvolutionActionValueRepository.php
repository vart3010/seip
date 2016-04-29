<?php

namespace Pequiven\IndicatorBundle\Repository\Indicator\EvolutionIndicator;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de los valores y observaciones de las acciones
 */
class EvolutionActionValueRepository extends SeipEntityRepository {

    protected function getAlias() {
        return 'ev';
    }

}