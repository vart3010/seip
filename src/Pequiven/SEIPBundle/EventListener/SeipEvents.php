<?php

namespace Pequiven\SEIPBundle\EventListener;

/**
 * Eventos del sistema
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
final class SeipEvents 
{
    /**
     * El pequiven.value_indicator.pre_add evento cuando se agrega un valor de indicator a un indicador
     * en el sistema.
     *
     * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const VALUE_INDICATOR_PRE_ADD = 'pequiven.value_indicator.pre_add';
    
    /**
     * El pequiven.value_indicator.pre_update evento cuando se actualiza un valor de indicator a un indicador
     * en el sistema.
     *
    
     *  * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const VALUE_INDICATOR_PRE_UPDATE = 'pequiven.value_indicator.pre_update';
    
    /**
     * El pequiven.indicator.pre_add_observation este evento ocurre cuando se agrega una observacion a un indicator
     * en el sistema.
     *
    
     *  * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const INDICATOR_PRE_ADD_OBSERVATION = 'pequiven.indicator.pre_add_observation';
}