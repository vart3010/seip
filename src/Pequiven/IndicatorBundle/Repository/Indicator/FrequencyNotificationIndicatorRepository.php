<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\IndicatorBundle\Repository\Indicator;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de las freuencias de notificación de los indicadores
 */
class FrequencyNotificationIndicatorRepository extends SeipEntityRepository {

    /**
     * Retorna query builder de los componentes activos
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryResultAll() {
        $qb = $this->getAllActive();
        return $qb->getQuery()->getResult();
    }
    
    protected function getAlias() {
        return 'fn';
    }

}
