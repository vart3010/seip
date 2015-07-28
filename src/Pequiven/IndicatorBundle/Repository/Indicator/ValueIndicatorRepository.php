<?php

namespace Pequiven\IndicatorBundle\Repository\Indicator;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de las freuencias de notificación de los indicadores
 */
class ValueIndicatorRepository extends SeipEntityRepository {

    protected function getAlias() {
        return 'vi';
    }

}
