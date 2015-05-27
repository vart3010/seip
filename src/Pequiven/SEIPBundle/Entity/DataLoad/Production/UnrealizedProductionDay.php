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
 * Detalles de la produccion no realizada en un dia
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_product_unrealized_production_day")
 * @ORM\Entity()
 */
class UnrealizedProductionDay 
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
     *
     * @var type 
     */
    private $internalCauses;
}
