<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\IndicatorBundle\Entity\Indicator;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Detalle de valor de indicador (Este solo deberia aplicar para el nivel operativo)
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class IndicatorDetailValue 
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
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;
    
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;
    
    private $typeCalculation;
    
    
    private $products;
    
    private $subject;
    
    public function __construct() {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function configureFormFields(Symfony\Component\Form\FormBuilder $form)
    {
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->subject;
    }
}
