<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Validator\Constraints\DataLoad;

use Pequiven\SEIPBundle\Validator\Constraints\BaseConstraintValidator;
use Symfony\Component\Validator\Constraint;

/**
 * Validador de produccion diaria
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ProductDetailDailyMonthValidator extends BaseConstraintValidator {

    public function validate($value, Constraint $constraint) {
        $request = $this->getRequest();

        $dateString = $request->get('dateNotification', null);
        $dateNotification = null;
        if ($dateString !== null) {
            $dateNotification = \DateTime::createFromFormat('d/m/Y', $dateString);
        }
        $day = (int) $dateNotification->format("d");
        
        $canBeNetProductionGreaterThanGross = $value->getProductReport()->getPlantReport()->getEntity()->getCanBeNetProductionGreaterThanGross();
        
        if($canBeNetProductionGreaterThanGross === true){
            $isValidNet = true;
        } else {
            $isValidNet = $value->isValidNet($day);
        }
        
        if ($isValidNet === false) {
            $this->context->addViolation('pequiven.validators.product_detail_daily_month.net_production_can_not_exceed_gross', array(
                '%gross%' => $value->getValueGrossByDay($day),
                '%net%' => $value->getValueNetByDay($day),
                '%product%' => $value->getProductReport()
            ));
        }
        
        $obs = $value->getObservationByDay($day);
        
        if (strlen($obs) > 255) {
            $this->context->addViolation('pequiven.validators.product_detail_daily_month.long_observation');
        }
    }

}
