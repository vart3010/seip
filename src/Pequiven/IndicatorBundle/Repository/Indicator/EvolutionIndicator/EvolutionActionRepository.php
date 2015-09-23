<?php

namespace Pequiven\IndicatorBundle\Repository\Indicator\EvolutionIndicator;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de las acciones
 */
class EvolutionActionRepository extends SeipEntityRepository {

    protected function getAlias() {
        return 'ea';
    }

}