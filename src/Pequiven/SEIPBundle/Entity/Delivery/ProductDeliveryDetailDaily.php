<?php

namespace Pequiven\SEIPBundle\Entity\Delivery;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\Delivery\ProductDeliveryDetailDaily as BaseModel;

/**
 * Description of ProductDeliveryDetailDaily
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 * @ORM\Table(name="seip_delivery_product_detail_daily")
 */
class ProductDeliveryDetailDaily extends BaseModel  {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

//    /**
//     * Producto de reporte
//     * @var \Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery
//     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery",inversedBy="productDeliveryDetailDaily")
//     * @ORM\JoinColumn(nullable=false)
//     */
//    private $productReportDelivery;

    function getId() {
        return $this->id;
    }
//
//    function getProductReportDelivery() {
//        return $this->productReportDelivery;
//    }

    function setId($id) {
        $this->id = $id;
    }

//    function setProductReportDelivery(\Pequiven\SEIPBundle\Entity\Delivery\ProductReportDelivery $productReportDelivery) {
//        $this->productReportDelivery = $productReportDelivery;
//    }

}
