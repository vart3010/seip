<?php

namespace Pequiven\SEIPBundle\EventListener;

/**
 * Eventos del sistema
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
final class SeipEvents {

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

    /*     * pequiven.indicator.pre_add_observation
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

    /**
     * El pequiven.report_template.delivery.pre_create este evento es lanzado antes de crear una plantilla de reporte de despacho
     * en el sistema.
     *

     *  * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const REPORT_TEMPLATE_DELIVERY_PRE_CREATE = 'pequiven.report_template_delivery.pre_create';

    /**
     * El pequiven.plant_report.pre_create este evento es lanzado antes de crear una planta
     * en el sistema.
     *

     *  * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const REPORT_PLANT_PRE_CREATE = 'pequiven.plant_report.pre_create';

    /**
     * El pequiven.unrealized_production.pre_create este evento es lanzado antes de crear cargar PNR
     * en el sistema.
     *

     *  * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const REPORT_UNREALIZED_PRODUCT_PRE_CREATE = 'pequiven.unrealized_production.pre_create';

    /**
     * El pequiven.inventory.pre_create este evento es lanzado antes de crear cargar PNR
     * en el sistema.
     *

     *  * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const REPORT_INVENTORY_PRE_CREATE = 'pequiven.inventory.pre_create';

    /**
     * El pequiven.product_report.pre_create este evento es lanzado antes de crear un producto de un reporte
     * en el sistema.
     *

     *  * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const PRODUCT_REPORT_PRE_CREATE = 'pequiven.product_report.pre_create';

    /**
     * El pequiven.product_planning.pre_create este evento es lanzado antes de crear una planificacion de producto
     * en el sistema.
     *

     *  * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const PRODUCT_PLANNING_PRE_CREATE = 'pequiven.product_planning.pre_create';

    /**
     * El pequiven.range.pre_create este evento es lanzado antes de crear un rango de distribucion
     * en el sistema.
     *

     *  * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const PRODUCT_RANGE_CREATE = 'pequiven.range.pre_create';

    /**
     * El pequiven.product_detail_daily_month.pre_create este evento es lanzado antes de crear un detalle de produccion
     * en el sistema.
     *

     *  * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const PRODUCT_PRODUCT_DETAIL_DAILY_MONTH_PRE_CREATE = 'pequiven.product_detail_daily_month.pre_create';

    /**
     * El pequiven.plant_stop_planning.pre_create este evento es lanzado antes de crear una planificacion de parada
     * en el sistema.
     *

     *  * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const PLANT_STOP_PLANNING_PRE_CREATE = 'pequiven.plant_stop_planning.pre_create';

    /**
     * El pequiven.plant_stop_planning.pre_update este evento es lanzado antes de actualizar una planificacion de parada
     * en el sistema.
     *

     *  * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const PLANT_STOP_PLANNING_PRE_UPDATE = 'pequiven.plant_stop_planning.pre_update';

}
