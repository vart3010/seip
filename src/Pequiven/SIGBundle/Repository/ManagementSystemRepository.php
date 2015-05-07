<?php

namespace Pequiven\SIGBundle\Repository;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de sistema de gestión (pequiven.repository.sig_management_system)
 *
 */
class ManagementSystemRepository extends SeipEntityRepository
{
    protected function getAlias() {
        return 'ms';
    }
}
