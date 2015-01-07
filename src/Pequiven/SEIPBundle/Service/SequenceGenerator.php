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
 * Generate the sequence of entities
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
    
    public function setSequenceGenerator(\Tecnocreaciones\Bundle\ToolsBundle\Service\SequenceGenerator $sequenceGenerator) {
        $this->sequenceGenerator = $sequenceGenerator;
    }
}
