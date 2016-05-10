<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tecnocreaciones\Bundle\BoxBundle\Model\Adapter;

use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Busca los widgets de los usuarios logueado para renderizarlos
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class UserSessionDoctrineORMAdapter extends BoxBaseAdapter
{
            
    function getModelBoxes()
    {
        $user = $this->getUser();
        return $user->getModelBoxes();
    }
}
