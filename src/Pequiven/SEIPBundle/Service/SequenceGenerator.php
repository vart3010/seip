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
        if($arrangementProgram->getType() == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC){
            $type = 'TAC';
        }
        if($arrangementProgram->getType() == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE){
            $type = 'OPT';
        }
        $mask = 'PG-{yyyy}-{gerencia}-{type}-{000}';
        return $this->sequenceGenerator->generateNext($qb,$mask,'ref',array(
            'gerencia' => 'GER',
            'type' => $type
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
