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
}
