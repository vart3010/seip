<?php

namespace Pequiven\MasterBundle\Repository;

use Tecnocreaciones\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * Description of variableRepository
 *
 * @author victor tortolero
 */
class VariableRepository extends EntityRepository {

    function getVariablesByFormula($formulaId) {
        $qb = $this->getQueryBuilder();
        $qb
                ->innerJoin('v.formulas', 'f')
                ->andWhere('f.id=  :idFormula')
                ->setParameter('idFormula', $formulaId)
        ;
        return $qb->getQuery();
    }

    protected function getAlias() {
        return 'v';
    }

}
