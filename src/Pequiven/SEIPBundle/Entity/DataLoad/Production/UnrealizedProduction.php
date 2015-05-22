<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\DataLoad\Production;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\DataLoad\DetailValue;

/**
 * Produccion no realizada (PNR)
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_product_unrealized_production")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class UnrealizedProduction extends DetailValue
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
     * Reporte de planta
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\ProductReport",inversedBy="unrealizedProductions")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $productReport;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function calculate()
    {
        $reflection = new \ReflectionClass($this);
        $methods = $reflection->getMethods();
        
        $nameMatch = '^getDay\w+$';
        
        $total = $totalPlan = 0.0;
        foreach ($methods as $method) {
            $methodName = $method->getName();
            $class = $method->getDeclaringClass();
            if(!strpos($class, 'Pequiven\SEIPBundle\Model\DataLoad\DetailValue')){
                continue;
            }
            if(preg_match('/'.$nameMatch.'/i', $methodName)){
                $value = $this->$methodName();
                $total +=  $value;
            }
        }
        
        $methodTotalPlan = "setTotal";
        
        $this->$methodTotalPlan($total);
    }
}
