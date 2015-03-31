<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Model\Evaluation;

/**
 * Interfaz para definir los elementos que se puedan evaluar
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
interface AuditableInterface 
{
    /**
     * Is validAudit
     *
     * @return boolean 
     */
    public function isValidAudit();
}
