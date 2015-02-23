<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Service;

/**
 * Generate the sequence of entities (seip.sequence_generator)
 *
 * @author Carlos Mendoza <inhack20@tecnocreaciones.com>
 */
class SequenceGenerator
{
    /**
     *
     * @var \Tecnocreaciones\Bundle\ToolsBundle\Service\SequenceGenerator
     */
    private $sequenceGenerator;
    
    /**
     * Generate sequence plants from your company
     * @param \Coramer\Sigtec\CompanyBundle\Entity\Company $company
     * @return string
     */
    public function getNextArrangementProgram(\Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram $arrangementProgram) {
        $qb = $this->sequenceGenerator->createQueryBuilder();
        $qb
            ->from('Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram', 'ap')
            ;
        
        $gerencia = 'ERROR';
        if($arrangementProgram->getType() == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC){
            $type = 'TAC';
            $gerencia = $arrangementProgram->getTacticalObjective()->getGerencia()->getAbbreviation();
        }
        if($arrangementProgram->getType() == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE){
            $type = 'OPT';
            $gerencia = $arrangementProgram->getOperationalObjective()->getGerenciaSecond()->getAbbreviation();
        }
        $gerencia = strtoupper($gerencia);
        $year = $arrangementProgram->getPeriod()->getYear();
        $mask = 'PG-{year}-{gerencia}-{type}-{000}';
        return $this->sequenceGenerator->generateNext($qb,$mask,'ref',array(
            'gerencia' => $gerencia,
            'type' => $type,
            'year' => $year
        ));
    }
    
    function getNextTempArrangementProgram()
    {
        $qb = $this->sequenceGenerator->createQueryBuilder();
        $qb->from('Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram', 'ap')
            ;
        return $this->sequenceGenerator->generateNextTemp($qb,'ref');
    }
    
    /**
     * Genera la referencia del objetivo
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $objetive
     * @return string
     * @throws \Exception
     */
    public function getNextRefChildObjetive(\Pequiven\ObjetiveBundle\Entity\Objetive $objetive)
    {
        $quantityParents = 0;
        $parents = $childrens = array();
        if($objetive->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Model\ObjetiveLevel::LEVEL_ESTRATEGICO){
            foreach ($objetive->getLineStrategics() as $lastParent) {
                $quantityParents++;
            }
            foreach ($lastParent->getObjetives() as $objetiveOfLine) {
                if($objetiveOfLine->getPeriod() !== $objetive->getPeriod()){
                    continue;
                }
                $childrens[] = $objetiveOfLine;
            }
        }else{
            $parents = $objetive->getParents();
            $quantityParents = count($parents);
            if($quantityParents == 0){
                throw new \Exception(sprintf('The objetive "%s (%s)" is not defined parent',(string)$objetive,$objetive->getId()));
            }
            $lastParent = $parents[count($parents) - 1]; 
            $childrens = $lastParent->getChildrens();
        }
        $refParent = $lastParent->getRef();
        $lengthRefPartent = (count(explode('.', $refParent)) - 1);
        
        $refChildDefined = array();
        foreach ($childrens as $child) {
            $refChildDefined[] = $child->getRef();
        }
        $lastDigit = $lastDigitTemp = 0;
        foreach ($refChildDefined as $value) {
            if($value == null){
                continue;
            }
            $valueExplode = explode('.', $value);
            for($i = ($lengthRefPartent + 1); $i > 0; $i--){
                if($valueExplode[$i] == ''){
                    continue;
                }
                $lastDigitTemp = $valueExplode[$i];
                break;
            }
            $lastDigitTemp = (int)str_replace('m', '', $lastDigitTemp);
            if($lastDigitTemp > $lastDigit){
                $lastDigit = $lastDigitTemp;
            }
        }
        $lastDigit++;
        
        $sufix = '';
        if($quantityParents > 1){
            $sufix = 'm';
        }
        $nextRef = $refParent . $lastDigit.'.'.$sufix;
        
//        var_dump('ID Parent '.$lastParent->getId());
//        var_dump('ID child '.$objetive->getId());
//        var_dump('count Parent '.count($parents));
//        var_dump('Count childrens '.count($childrens));
//        var_dump('Ref parent '.$refParent);
//        var_dump('Ref length Parent '.$lengthRefPartent);
//        var_dump('Ref length child '.$lengthRefPartent);
//        var_dump('Next Ref '.$nextRef);
//        var_dump($refChildDefined);
//        die;
        return $nextRef;
    }
    
    public function getNextRefPrePlanningUser(\Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningUser $prePlanningUser)
    {
        $qb = $this->sequenceGenerator->createQueryBuilder();
        $qb
            ->from('Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningUser', 'p')
            ;
        
        $gerencia = 'ERROR';
        if($prePlanningUser->getLevelPlanning() == \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning::LEVEL_TACTICO){
            $type = 'TAC';
            $gerencia = $prePlanningUser->getGerenciaFirst()->getAbbreviation();
        }
        if($prePlanningUser->getLevelPlanning() == \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning::LEVEL_OPERATIVO){
            $type = 'OPT';
            $gerencia = $prePlanningUser->getGerenciaSecond()->getAbbreviation();
        }
        $year = $prePlanningUser->getPeriod()->getYear();
        $mask = 'P-{year}-{gerencia}-{type}-{000}';
        return $this->sequenceGenerator->generateNext($qb,$mask,'ref',array(
            'gerencia' => strtoupper($gerencia),
            'type' => $type,
            'year' => $year,
        ));
    }
    
    public function setSequenceGenerator(\Tecnocreaciones\Bundle\ToolsBundle\Service\SequenceGenerator $sequenceGenerator) {
        $this->sequenceGenerator = $sequenceGenerator;
    }
}
