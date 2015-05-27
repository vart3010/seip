<?php

namespace Pequiven\ObjetiveBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Objetivo
 *
 * @author matias
 */
abstract class Objetive implements ObjetiveInterface
{
    /**
     * Estatus borrador
     */
    const STATUS_DRAFT = 0;
    
    /**
     * Estatus Aprobado
     */
    const STATUS_APPROVED = 1;
    
    /**
     * Nivel de objetivo
     * 
     * @var \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel
     * @ORM\ManyToOne(targetEntity="\Pequiven\ObjetiveBundle\Entity\ObjetiveLevel")
     * @ORM\JoinColumn(name="fk_objetive_level", referencedColumnName="id")
     */
    protected $objetiveLevel;
    
    /**
     * Programas de gestion a nivel tactico
     * 
     * @var \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram
     * @ORM\OneToMany(targetEntity="Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram",mappedBy="tacticalObjective",cascade={"remove"})
     */
    protected $tacticalArrangementPrograms;
    
    /**
     * Programas de gestion a nivel operativo
     * 
     * @var \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram
     * @ORM\OneToMany(targetEntity="Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram",mappedBy="operationalObjective",cascade={"remove"})
     */
    protected $operationalArrangementPrograms;
    
    const TYPE_OBJECT = 'objetive';
    
    public function create(){
        
    }
    
    /**
     * Devuelve el valor de referencia del objetivo
     * @param type $options
     */
    public function setNewRef($options = array()){
        
    }
    
    /**
     * Set objetiveLevel
     *
     * @param \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel $objetiveLevel
     * @return Objetive
     */
    public function setObjetiveLevel(\Pequiven\ObjetiveBundle\Entity\ObjetiveLevel $objetiveLevel = null) {
        
        $this->objetiveLevel = $objetiveLevel;

        return $this;
    }

    /**
     * Get objetiveLevel
     *
     * @return \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel 
     */
    public function getObjetiveLevel() {
        return $this->objetiveLevel;
    }
    
    /**
     * Add tacticalArrangementPrograms
     *
     * @param \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram $tacticalArrangementPrograms
     * @return Objetive
     */
    public function addTacticalArrangementProgram(\Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram $tacticalArrangementPrograms)
    {
        $this->tacticalArrangementPrograms->add($tacticalArrangementPrograms);

        return $this;
    }

    /**
     * Remove tacticalArrangementPrograms
     *
     * @param \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram $tacticalArrangementPrograms
     */
    public function removeTacticalArrangementProgram(\Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram $tacticalArrangementPrograms)
    {
        $this->tacticalArrangementPrograms->removeElement($tacticalArrangementPrograms);
    }

    /**
     * Get tacticalArrangementPrograms
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTacticalArrangementPrograms()
    {
        return $this->tacticalArrangementPrograms;
    }

    /**
     * Add operationalArrangementPrograms
     *
     * @param \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram $operationalArrangementPrograms
     * @return Objetive
     */
    public function addOperationalArrangementProgram(\Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram $operationalArrangementPrograms)
    {
        $this->operationalArrangementPrograms->add($operationalArrangementPrograms);

        return $this;
    }

    /**
     * Remove operationalArrangementPrograms
     *
     * @param \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram $operationalArrangementPrograms
     */
    public function removeOperationalArrangementProgram(\Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram $operationalArrangementPrograms)
    {
        $this->operationalArrangementPrograms->removeElement($operationalArrangementPrograms);
    }

    /**
     * Get operationalArrangementPrograms
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOperationalArrangementPrograms()
    {
        return $this->operationalArrangementPrograms;
    }
    
    /**
     * Retorna los programas de gestion asociados al objetivo
     * @return type
     */
    public function getArrangementPrograms()
    {
        $objetiveLevel = $this->getObjetiveLevel();
        $arrangementPrograms = array();
        if($objetiveLevel->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO){
            $arrangementProgramsResult = $this->getTacticalArrangementPrograms();
            foreach ($arrangementProgramsResult as $arrangementProgram) {
                if($arrangementProgram->getType() == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC){
                    $arrangementPrograms[] = $arrangementProgram;
                }
            }
            
        } elseif ($objetiveLevel->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_OPERATIVO){
            $arrangementPrograms = $this->getOperationalArrangementPrograms();
        }
        return $arrangementPrograms;
    }
    
    public function getGerenciaByLevel() {
        $objetiveLevel = $this->getObjetiveLevel();
        $gerencia = null;
        if($objetiveLevel->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO){
            $gerencia = $this->getGerencia();
        }elseif($objetiveLevel->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_OPERATIVO){
            $gerencia = $this->getGerenciaSecond()->getGerencia();
        }
        return $gerencia;
    }
    
    /**
     * Retorna las etiquetas definidas para los estatus del objetivo
     * 
     * @staticvar array $labelsStatus
     * @return string
     */
    static function getLabelsStatus()
    {
        static $labelsStatus = array(
            self::STATUS_DRAFT => 'pequiven_objetive.status.draft',
            self::STATUS_APPROVED => 'pequiven_objetive.status.approved',
        );
        return $labelsStatus;
    }
    
    /**
     * Retorna la etiqueta que corresponde a un estatus del objetivo
     * @return string
     */
    function getLabelStatus()
    {
        $labels = $this->getLabelsStatus();
        if(isset($labels[$this->status])){
            return $labels[$this->status];
        }
    }
}
