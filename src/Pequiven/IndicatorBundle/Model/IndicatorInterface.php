<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\IndicatorBundle\Model;

/**
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
interface IndicatorInterface 
{    
    function getValuesIndicator();
    /**
     * @return \Pequiven\MasterBundle\Entity\Formula\FormulaDetail Description
     */
    function getFormulaDetails();
}
