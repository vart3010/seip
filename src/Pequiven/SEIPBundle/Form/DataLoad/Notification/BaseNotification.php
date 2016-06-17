<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Form\DataLoad\Notification;

use DateTime;
use Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate;
use Pequiven\SEIPBundle\Form\SeipAbstractForm;

/**
 * Description of BaseNotification
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class BaseNotification extends SeipAbstractForm
{
    protected $dateNotification;
    
    /**
     *
     * @var ReportTemplate
     */
    protected $reportTemplate;
            
    function __construct(DateTime $dateNotification,ReportTemplate $reportTemplate) 
    {
        $this->dateNotification = $dateNotification;
        $this->reportTemplate = $reportTemplate;
    }
    
    protected function getMonthNotification()
    {
        return (int)$this->dateNotification->format("m");
    }
    
    protected function getDayNotification()
    {
        return (int)$this->dateNotification->format("d");
    }
    
    protected function getParametersDisabled()
    {
        return array(
            'label_attr' => array('class' => 'label'),
            "attr" => array("class" => "input-unstyled input-mini"),
            "disabled" => true,
        );
    }
    
    protected function getParametersStandard()
    {
        return array(
            'label_attr' => array('class' => 'label'),
            "attr" => array("class" => "input input-mini"),
        );
    }
}
