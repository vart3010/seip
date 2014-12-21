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
     * El pequiven_seip.arrangementprogram.pre_create evento es lanzado antes de crear un programa de gestion
     * en el sistema.
     *
     * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const ARRANGEMENT_PROGRAM_PRE_CREATE = 'pequiven_seip.arrangementprogram.pre_create';
    
    /**
     * El pequiven_seip.arrangementprogram.post_create evento es lanzado despues de crear un programa de gestion
     * en el sistema.
     *
     * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const ARRANGEMENT_PROGRAM_POST_CREATE = 'pequiven_seip.arrangementprogram.post_create';
    
    /**
     * El pequiven_seip.arrangementprogram.pre_update evento es lanzado antes de actualizar un programa de gestion
     * en el sistema.
     *
     * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const ARRANGEMENT_PROGRAM_PRE_UPDATE = 'pequiven_seip.arrangementprogram.pre_update';
    
    /**
     * El pequiven_seip.arrangementprogram.pre_create evento es lanzado antes de elimina un programa de gestion
     * en el sistema.
     *
     * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const ARRANGEMENT_PROGRAM_PRE_DELETE = 'pequiven_seip.arrangementprogram.pre_delete';
    
    /**
     * El pequiven_seip.arrangementprogram.pre_revised evento es lanzado antes de revisar un programa de gestion
     * en el sistema.
     *
     * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const ARRANGEMENT_PROGRAM_PRE_REVISED = 'pequiven_seip.arrangementprogram.pre_revised';
    
    /**
     * El pequiven_seip.arrangementprogram.post_revised evento es lanzado despues de revisar un programa de gestion
     * en el sistema.
     *
     * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const ARRANGEMENT_PROGRAM_POST_REVISED = 'pequiven_seip.arrangementprogram.post_revised';
    
    /**
     * El pequiven_seip.arrangementprogram.pre_approved evento es lanzado antes de aprobar un programa de gestion
     * en el sistema.
     *
     * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const ARRANGEMENT_PROGRAM_PRE_APPROVED = 'pequiven_seip.arrangementprogram.pre_approved';
    
    /**
     * El pequiven_seip.arrangementprogram.post_approved evento es lanzado despues de aprobar un programa de gestion
     * en el sistema.
     *
     * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const ARRANGEMENT_PROGRAM_POST_APPROVED = 'pequiven_seip.arrangementprogram.post_approved';
    
    /**
     * El pequiven_seip.arrangementprogram.pre_send_to_review evento es lanzado antes de enviar a revision un programa de gestion
     * en el sistema.
     *
     * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const ARRANGEMENT_PROGRAM_PRE_SEND_TO_REVIEW = 'pequiven_seip.arrangementprogram.pre_send_to_review';
    
    /**
     * El pequiven_seip.arrangementprogram.post_send_to_review evento es lanzado despues de enviar a revision un programa de gestion
     * en el sistema.
     *
     * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const ARRANGEMENT_PROGRAM_POST_SEND_TO_REVIEW = 'pequiven_seip.arrangementprogram.post_send_to_review';
    
    /**
     * El pequiven_seip.arrangementprogram.pre_rejected evento es lanzado antes de rechazar un programa de gestion
     * en el sistema.
     *
     * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const ARRANGEMENT_PROGRAM_PRE_REJECTED = 'pequiven_seip.arrangementprogram.pre_rejected';
    
    /**
     * El pequiven_seip.arrangementprogram.post_rejected evento es lanzado despues de rechazar un programa de gestion
     * en el sistema.
     *
     * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const ARRANGEMENT_PROGRAM_POST_REJECTED = 'pequiven_seip.arrangementprogram.post_rejected';
    
    /**
     * El pequiven_seip.arrangementprogram.pre_return_to_draft evento es lanzado antes de regresar un programa de gestion a borrador
     * en el sistema.
     *
     * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const ARRANGEMENT_PROGRAM_PRE_RETURN_TO_DRAFT = 'pequiven_seip.arrangementprogram.pre_return_to_draft';
    
    /**
     * El pequiven_seip.arrangementprogram.post_return_to_draft evento es lanzado cuando se regresa un programa de gestion a borrador
     * en el sistema.
     *
     * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const ARRANGEMENT_PROGRAM_POST_RETURN_TO_DRAFT = 'pequiven_seip.arrangementprogram.post_return_to_draft';
    
    /**
     * El pequiven_seip.arrangementprogram.pre_return_to_review evento es lanzado cuando se regresa un programa de gestion a revision
     * en el sistema.
     *
     * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const ARRANGEMENT_PROGRAM_PRE_RETURN_TO_REVIEW = 'pequiven_seip.arrangementprogram.pre_return_to_review';
    
    /**
     * El pequiven_seip.arrangementprogram.pre_return_to_review evento es lanzado cuando se regresa un programa de gestion a revision
     * en el sistema.
     *
     * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const ARRANGEMENT_PROGRAM_POST_RETURN_TO_REVIEW = 'pequiven_seip.arrangementprogram.post_return_to_review';
    /**
     * El pequiven_seip.arrangementprogram.pre_start_the_notification_process evento es lanzado cuando un usuario inicia el proceso de notificacion en un programa de gestion
     * en el sistema.
     *
     * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const ARRANGEMENT_PROGRAM_PRE_START_THE_NOTIFICATION_PROCESS = 'pequiven_seip.arrangementprogram.pre_start_the_notification_process';
    
    /**
     * El pequiven_seip.arrangementprogram.post_start_the_notification_process evento es lanzado despues que un usuario inicia el proceso de notificacion en un programa de gestion
     * en el sistema.
     *
     * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const ARRANGEMENT_PROGRAM_POST_START_THE_NOTIFICATION_PROCESS = 'pequiven_seip.arrangementprogram.post_start_the_notification_process';
    
    /**
     * El pequiven_seip.arrangementprogram.pre_finish_the_notification_process evento es lanzado cuando un usuario finaliza el proceso de notificacion en un programa de gestion
     * en el sistema.
     *
     * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const ARRANGEMENT_PROGRAM_PRE_FINISH_THE_NOTIFICATION_PROCESS = 'pequiven_seip.arrangementprogram.pre_finish_the_notification_process';
    
    /**
     * El pequiven_seip.arrangementprogram.post_finish_the_notification_process evento es lanzado despues que un usuario finaliza el proceso de notificacion en un programa de gestion
     * en el sistema.
     *
     * The event listener receives an
     * Sylius\Bundle\ResourceBundle\Event\ResourceEvent instance.
     *
     * @var string
     */
    const ARRANGEMENT_PROGRAM_POST_FINISH_THE_NOTIFICATION_PROCESS = 'pequiven_seip.arrangementprogram.post_finish_the_notification_process';
}
