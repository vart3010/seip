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
    
    public function getNextRefChildObjetive(\Pequiven\ObjetiveBundle\Entity\Objetive $objetive)
    {
        $parents = $objetive->getParents();
        $quantityParents = count($parents);
        if($quantityParents == 0){
            throw new \Exception(sprintf('The objetive "%s (%s)" is not defined parent',(string)$objetive,$objetive->getId()));
        }
        $lastParent = $parents[count($parents) - 1]; 
        $refParent = $lastParent->getRef();
        $lengthRefPartent = (count(explode('.', $refParent)) - 1);
        
        $refChildDefined = array();
        foreach ($lastParent->getChildrens() as $child) {
            $refChildDefined[] = $child->getRef();
        }
        $lastDigit = $lastDigitTemp = 0;
        foreach ($refChildDefined as $value) {
            if($value == null){
                continue;
            }
            $valueExplode = explode('.', $value);
//            $valueExplode = explode('.', '1.2.1.');
            for($i = ($lengthRefPartent + 1); $i > 0; $i--){
                if($valueExplode[$i] == ''){
                    continue;
                }
                $lastDigitTemp = $valueExplode[$i];
                break;
            }
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
//        var_dump('Count childrens '.count($lastParent->getChildrens()));
//        var_dump('Ref parent '.$refParent);
//        var_dump('Ref length Parent '.$lengthRefPartent);
//        var_dump('Ref length child '.$lengthRefPartent);
//        var_dump('Next Ref '.$nextRef);
//        var_dump($refChildDefined);
        
        return $nextRef;
    }
    
    public function setSequenceGenerator(\Tecnocreaciones\Bundle\ToolsBundle\Service\SequenceGenerator $sequenceGenerator) {
        $this->sequenceGenerator = $sequenceGenerator;
    }
}
