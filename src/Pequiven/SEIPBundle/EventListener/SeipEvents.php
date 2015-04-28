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
    
    /**pequiven.indicator.pre_add_observation
     * El pequiven.indicator.pre_add_observation este evento ocurre cuando se agrega una observacion a un indicator
     * en el sistema.
     *
    
     *  * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const INDICATOR_PRE_ADD_OBSERVATION = 'pequiven.indicator.pre_add_observation';
    
    /**
     * El pequiven.result_arrangement_program.update este evento ocurre cuando se agrega una observacion a un indicator
     * en el sistema.
     *
    
     *  * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const RESULT_ARRANGEMENT_PROGRAM_UPDATE = 'result.arrangement_program_update';
    
    /**
     * El pre_planning.post.send_to_draft este evento ocurre cuando se envia un item de la pre-planificacion a borrador
     * en el sistema.
     *
    
     *  * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const PRE_PLANNING_POST_SEND_TO_DRAFT = 'pre_planning.post.send_to_draft';
    
    /**
     * El pre_planning.post.send_to_review este evento ocurre cuando se envia un item de la pre-planificacion a revision
     * en el sistema.
     *
    
     *  * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const PRE_PLANNING_POST_SEND_TO_REVIEW = 'pre_planning.post.send_to_review';
    
    /**
     * El pequiven.report_template.pre_create este evento es lanzado antes de crear una plantilla de reporte
     * en el sistema.
     *
    
     *  * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const REPORT_TEMPLATE_PRE_CREATE = 'pequiven.report_template.pre_create';
}