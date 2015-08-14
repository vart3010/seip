<?php

namespace Pequiven\SIGBundle\Repository;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de los tipos de Acción (pequiven.repository.sig_management_system)
 *
 */
class TypeActionManagementSystemRepository extends SeipEntityRepository
{
    protected function getAlias() {
        return 'ta';
    }
}