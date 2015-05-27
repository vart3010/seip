<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\DataLoad\Production;

use Doctrine\ORM\Mapping as ORM;

/**
 * Causa de PNR
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_product_unrealized_production_day_cause_fail")
 * @ORM\Entity()
 */
class CauseFail 
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * Causa o falla
     * @var \Pequiven\SEIPBundle\Entity\CEI\Fail
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Fail")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fail;
    
    /**
     * Cantidad
     * @var float
     * @ORM\Column(name="mount",type="float")
     */
    private $mount;
}
