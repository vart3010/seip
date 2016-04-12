<?php

namespace Pequiven\SEIPBundle\Repository\User;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * 
 * Notification User
 * 
 * 
 */
class NotificationRepository extends EntityRepository {

    function getAlias() {
        return 'un';
    }

}
