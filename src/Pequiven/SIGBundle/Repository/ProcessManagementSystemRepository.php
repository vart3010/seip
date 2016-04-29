<?php

namespace Pequiven\SIGBundle\Repository;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de los procesos de los sistemas de gestión
 *
 */
class ProcessManagementSystemRepository extends SeipEntityRepository
{
	protected function getAlias() {
        return 'pms';
    }
}
