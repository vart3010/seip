<?php

namespace Pequiven\SIGBundle\Repository;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio del tipo de verification (pequiven.repository.managementsystem_sig)
 *
 */
class TypeVerificationManagementSystemRepository extends SeipEntityRepository
{
    protected function getAlias() {
        return 'tv';
    }
}