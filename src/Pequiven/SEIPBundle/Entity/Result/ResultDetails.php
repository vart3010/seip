<?php

namespace Pequiven\SEIPBundle\Entity\Result;

use Doctrine\ORM\Mapping as ORM;

/**
 * Detalles de un resultado
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 * @ORM\Table()
 * @ORM\Entity()
 */
class ResultDetails 
{
    const JANUARY_RESULT = 'januaryResult';
    const FEBRUARY_RESULT = 'februaryResult';
    const MARCH_RESULT = 'marchResult';
    const APRIL_RESULT = 'aprilResult';
    const MAY_RESULT = 'mayResult';
    const JUNE_RESULT = 'juneResult';
    const JULY_RESULT = 'julyResult';
    const AUGUST_RESULT = 'augustResult';
    const SEPTEMBER_RESULT = 'septemberResult';
    const OCTOBER_RESULT = 'octoberResult';
    const NOVEMBER_RESULT = 'novemberResult';
    const DECEMBER_RESULT = 'decemberResult';
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Planificado para enero
     * @var float
     *
     * @ORM\Column(name="januaryResult", type="float",nullable=true)
     */
    private $januaryResult;

    /**
     * Planificado para febrero
     * @var float
     *
     * @ORM\Column(name="februaryResult", type="float",nullable=true)
     */
    private $februaryResult;

    /**
     * Planificado para marzo
     * @var float
     *
     * @ORM\Column(name="marchResult", type="float",nullable=true)
     */
    private $marchResult;

    /**
     * Planificado para abril
     * @var float
     *
     * @ORM\Column(name="aprilResult", type="float",nullable=true)
     */
    private $aprilResult;

    /**
     * Planificado para mayo
     * @var float
     *
     * @ORM\Column(name="mayResult", type="float",nullable=true)
     */
    private $mayResult;

    /**
     * Planificado para junio
     * @var float
     *
     * @ORM\Column(name="juneResult", type="float",nullable=true)
     */
    private $juneResult;

    /**
     * Planificado para julio
     * @var float
     *
     * @ORM\Column(name="julyResult", type="float",nullable=true)
     */
    private $julyResult;

    /**
     * Planificado para agosto
     * @var float
     *
     * @ORM\Column(name="augustResult", type="float",nullable=true)
     */
    private $augustResult;

    /**
     * Planificado para septiembre
     * @var float
     *
     * @ORM\Column(name="septemberResult", type="float",nullable=true)
     */
    private $septemberResult;

    /**
     * Planificado para octubre
     * @var float
     *
     * @ORM\Column(name="octoberResult", type="float",nullable=true)
     */
    private $octoberResult;

    /**
     * Planificado para noviembre
     * @var float
     *
     * @ORM\Column(name="novemberResult", type="float",nullable=true)
     */
    private $novemberResult;

    /**
     * Planificado para diciembre
     * @var float
     *
     * @ORM\Column(name="decemberResult", type="float",nullable=true)
     */
    private $decemberResult;
    
    /**
     * Resultado global
     * @var float
     *
     * @ORM\Column(name="globalResult", type="float",nullable=true)
     */
    private $globalResult = 0;
    
    /**
     * Resultado global con peso
     * @var float
     *
     * @ORM\Column(name="globalResultWithWeight", type="float",nullable=true)
     */
    private $globalResultWithWeight = 0;

    /**
     * Estatus
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status = 0;
    
    /**
     * Resultado
     * 
     * @var \Pequiven\SEIPBundle\Entity\Result\Result
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\Result\Result",mappedBy="resultDetails")
     */
    private $result;

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
     * Set januaryResult
     *
     * @param float $januaryResult
     * @return ResultDetails
     */
    public function setJanuaryResult($januaryResult)
    {
        $this->januaryResult = $januaryResult;

        return $this;
    }

    /**
     * Get januaryResult
     *
     * @return float 
     */
    public function getJanuaryResult()
    {
        return $this->januaryResult;
    }

    /**
     * Set februaryResult
     *
     * @param float $februaryResult
     * @return ResultDetails
     */
    public function setFebruaryResult($februaryResult)
    {
        $this->februaryResult = $februaryResult;

        return $this;
    }

    /**
     * Get februaryResult
     *
     * @return float 
     */
    public function getFebruaryResult()
    {
        return $this->februaryResult;
    }

    /**
     * Set marchResult
     *
     * @param float $marchResult
     * @return ResultDetails
     */
    public function setMarchResult($marchResult)
    {
        $this->marchResult = $marchResult;

        return $this;
    }

    /**
     * Get marchResult
     *
     * @return float 
     */
    public function getMarchResult()
    {
        return $this->marchResult;
    }

    /**
     * Set aprilResult
     *
     * @param float $aprilResult
     * @return ResultDetails
     */
    public function setAprilResult($aprilResult)
    {
        $this->aprilResult = $aprilResult;

        return $this;
    }

    /**
     * Get aprilResult
     *
     * @return float 
     */
    public function getAprilResult()
    {
        return $this->aprilResult;
    }

    /**
     * Set mayResult
     *
     * @param float $mayResult
     * @return ResultDetails
     */
    public function setMayResult($mayResult)
    {
        $this->mayResult = $mayResult;

        return $this;
    }

    /**
     * Get mayResult
     *
     * @return float 
     */
    public function getMayResult()
    {
        return $this->mayResult;
    }

    /**
     * Set juneResult
     *
     * @param float $juneResult
     * @return ResultDetails
     */
    public function setJuneResult($juneResult)
    {
        $this->juneResult = $juneResult;

        return $this;
    }

    /**
     * Get juneResult
     *
     * @return float 
     */
    public function getJuneResult()
    {
        return $this->juneResult;
    }

    /**
     * Set julyResult
     *
     * @param float $julyResult
     * @return ResultDetails
     */
    public function setJulyResult($julyResult)
    {
        $this->julyResult = $julyResult;

        return $this;
    }

    /**
     * Get julyResult
     *
     * @return float 
     */
    public function getJulyResult()
    {
        return $this->julyResult;
    }

    /**
     * Set augustResult
     *
     * @param float $augustResult
     * @return ResultDetails
     */
    public function setAugustResult($augustResult)
    {
        $this->augustResult = $augustResult;

        return $this;
    }

    /**
     * Get augustResult
     *
     * @return float 
     */
    public function getAugustResult()
    {
        return $this->augustResult;
    }

    /**
     * Set septemberResult
     *
     * @param float $septemberResult
     * @return ResultDetails
     */
    public function setSeptemberResult($septemberResult)
    {
        $this->septemberResult = $septemberResult;

        return $this;
    }

    /**
     * Get septemberResult
     *
     * @return float 
     */
    public function getSeptemberResult()
    {
        return $this->septemberResult;
    }

    /**
     * Set octoberResult
     *
     * @param float $octoberResult
     * @return ResultDetails
     */
    public function setOctoberResult($octoberResult)
    {
        $this->octoberResult = $octoberResult;

        return $this;
    }

    /**
     * Get octoberResult
     *
     * @return float 
     */
    public function getOctoberResult()
    {
        return $this->octoberResult;
    }

    /**
     * Set novemberResult
     *
     * @param float $novemberResult
     * @return ResultDetails
     */
    public function setNovemberResult($novemberResult)
    {
        $this->novemberResult = $novemberResult;

        return $this;
    }

    /**
     * Get novemberResult
     *
     * @return float 
     */
    public function getNovemberResult()
    {
        return $this->novemberResult;
    }

    /**
     * Set decemberResult
     *
     * @param float $decemberResult
     * @return ResultDetails
     */
    public function setDecemberResult($decemberResult)
    {
        $this->decemberResult = $decemberResult;

        return $this;
    }

    /**
     * Get decemberResult
     *
     * @return float 
     */
    public function getDecemberResult()
    {
        return $this->decemberResult;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return ResultDetails
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set result
     *
     * @param \Pequiven\SEIPBundle\Entity\Result\Result $result
     * @return ResultDetails
     */
    public function setResult(\Pequiven\SEIPBundle\Entity\Result\Result $result = null)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return \Pequiven\SEIPBundle\Entity\Result\Result 
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set globalResult
     *
     * @param float $globalResult
     * @return ResultDetails
     */
    public function setGlobalResult($globalResult)
    {
        $now = new \DateTime();
        $monthResult = self::getMonthResult($now->format('m'));
        $propertyAccessor = \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor();
        $propertyAccessor->setValue($this, $monthResult, $globalResult);
        
        $weight = $this->getResult()->getWeight();
        
        $this->globalResultWithWeight = ($globalResult * $weight) / 100;
        
        $this->globalResult = $globalResult;

        return $this;
    }

    /**
     * Get globalResult
     *
     * @return float 
     */
    public function getGlobalResult()
    {
        return $this->globalResult;
    }
    
    function getGlobalResultWithWeight() 
    {
        return $this->globalResultWithWeight;
    }

    function setGlobalResultWithWeight($globalResultWithWeight) 
    {
        $this->globalResultWithWeight = $globalResultWithWeight;
        
        return $this;
    }
        
    static function getMonthResult($month) {
        $months = self::getMonthsResult();
        if(is_string($month) === true){
            $month = (int)$month;
        }
        if(!isset($months[$month])){
            throw new \Exception(sprintf('month result "%s" not defined',$month));
        }
        return $months[$month];
    }

    /**
     * Devuelve un array asociativo de el string real con el mes que corresponde
     * @staticvar array $months
     * @return int
     */
    static function getMonthsResult(){
        static $months = array(
            1 => self::JANUARY_RESULT ,
            2 => self::FEBRUARY_RESULT,
            3 => self::MARCH_RESULT,
            4 => self::APRIL_RESULT,
            5 => self::MAY_RESULT,
            6 => self::JUNE_RESULT,
            7 => self::JULY_RESULT,
            8 => self::AUGUST_RESULT,
            9 => self::SEPTEMBER_RESULT,
            10 => self::OCTOBER_RESULT,
            11 => self::NOVEMBER_RESULT,
            12 => self::DECEMBER_RESULT,
        );
        return $months;
    }
}
