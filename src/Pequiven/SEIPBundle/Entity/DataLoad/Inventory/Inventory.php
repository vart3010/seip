<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\DataLoad\Inventory;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\DataLoad\DetailValue;

/**
 * Inventario
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_product_inventory")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Inventory extends DetailValue
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
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\ProductReport",inversedBy="inventorys")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productReport;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    function getProductReport() {
        return $this->productReport;
    }

    function setProductReport(\Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productReport) {
        $this->productReport = $productReport;
        return $this;
    }
    
    public function __toString() 
    {
        $_toString = "-";
        if($this->getId() > 0){
            $_toString = $this->getMonthLabel();
        }
        return $_toString;
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
