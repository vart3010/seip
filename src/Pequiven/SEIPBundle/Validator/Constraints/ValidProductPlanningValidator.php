<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validador de presupuesto de produccion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ValidProductPlanningValidator extends BaseConstraintValidator
{
    public function validate($object, Constraint $constraint) 
    {
        $errorNoGross = "pequiven.validators.valid_product_planning.you_can_production_month_without_adding_gross_production_budget";
        $productReport = $object->getProductReport();
        
        $month = $object->getMonth();
        $type = $object->getType();
        if($type == \Pequiven\SEIPBundle\Model\DataLoad\Production\ProductPlanning::TYPE_NET)
        {
            $productPlanningsGross = $productReport->getProductPlanningsGross();
            if(!isset($productPlanningsGross[$month])){
                $monthsLabels = \Pequiven\SEIPBundle\Service\ToolService::getMonthsLabels();
                $this->context->addViolation($errorNoGross,array(
                    "%month%" => $this->trans($monthsLabels[$month])
                ));
            }
        }
        
//        $this->context->addViolation($errorNoGross,array(
//            "%month%" => "aaaa"
//        ));
    }
}
