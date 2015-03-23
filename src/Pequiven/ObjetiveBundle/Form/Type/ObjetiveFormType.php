<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\ObjetiveBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

/**
 * Formulario de objetivo
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ObjetiveFormType extends AbstractType 
{
      
    public function getName() 
    {
        return 'pequiven_objetive_form';
    }

}
