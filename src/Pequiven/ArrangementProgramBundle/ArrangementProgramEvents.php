<?php

namespace Pequiven\ArrangementProgramBundle;

/**
 * Eventos del bundle
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
final class ArrangementProgramEvents 
{
    /**
     * The store.order event is thrown each time an order is created
     * in the system.
     *
     * The event listener receives an
     * Acme\StoreBundle\Event\FilterOrderEvent instance.
     *
     * @var string
     */
    const ARRANGEMENT_PROGRAM_PRE_CREATE = 'pequiven_seip.arrangementprogram.pre_create';
}
