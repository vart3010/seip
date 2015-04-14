<?php

namespace Pequiven\SEIPBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modelo del gráfico
 *
 * @author matias
 */
abstract class Chart
{
    
    /**
     * Gráfico tipo dona para mostrar los indicadores asociados de acuerdo y junto con el resultado de medición
     */
    const TYPE_CHART_INDICATORS_ASSOCIATED = 0;
    
    /**
     * Gráfico tipo barras vertical para mostrar el real/plan de los indicadores asociados respecto al eje izquierdo y el resultado de la medición en valor porcentual respecto al lado derecho
     */
    const TYPE_CHART_COLUMN_REAL_PLAN = 1;
    
    /**
     * Gráfico tipo barras vertical para mostrar el real/plan de los parámetros de cada mes. Sólo para el caso en que sean 2 parámetros
     */
    const TYPE_CHART_COLUMN_FROM_FORMULA_PARAMETERS = 2;
    
    /**
     * Gráfico ???
     */
    const TYPE_CHART_PIE_FROM_TAGS = 3;
    
}