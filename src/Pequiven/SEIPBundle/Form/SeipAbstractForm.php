<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Form;

use Symfony\Component\Form\AbstractType;

/**
 * Description of SeipAbstractForm
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract  class SeipAbstractForm extends AbstractType
{
    protected function getQueryBuilderEnabled()
    {
        $queryBuilderEnabled = function (\Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository $repository){
            return $repository->getQueryAllEnabled();
        };
        return $queryBuilderEnabled;
    }
}
