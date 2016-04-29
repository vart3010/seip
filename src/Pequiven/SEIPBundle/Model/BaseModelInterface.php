<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Model;

/**
 * Intefaz de la entidad base
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
interface BaseModelInterface 
{
    function isEnabled();
    
    function getCreatedAt();

    function getUpdatedAt();

    function getDeletedAt();

    function setEnabled($enabled);

    function setCreatedAt(\DateTime $createdAt);

    function setUpdatedAt(\DateTime $updatedAt);

    function setDeletedAt(\DateTime $deletedAt);
}
