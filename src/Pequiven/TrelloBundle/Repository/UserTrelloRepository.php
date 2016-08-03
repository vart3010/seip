<?php

namespace Pequiven\TrelloBundle\Repository;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

class UserTrelloRepository extends EntityRepository 
{
    /**
     * Usuarios con ID's de trello
     */

    function findSeipUsers()
    {
        $qb = $this->getQueryBuilder();
        
        $qb->addSelect('CONCAT( CONCAT(u.firstname, \' \'),  u.lastname) fullname')
           ->where('u.trelloId != :null')->setParameter('null', serialize(null))
           ->andWhere('u.trelloId != :empty')->setParameter('empty',"");

        return $qb->getQuery()->getResult();
    }
    
    function findTrelloUsers()
    {
        $qb = $this->getQueryBuilder();
        
        $qb
            ->addSelect('CONCAT( CONCAT(u.firstname, \' \'),  u.lastname) fullname')
            ->innerJoin('ut.seipUser', 'u')
            ->andWhere('ut.trelloId != :null')
            ->setParameter('null', serialize(null))
            ->andWhere('ut.trelloId != :empty')
            ->setParameter('empty', "")
                ;

        return $qb->getQuery()->getResult();
    }
    
    protected function getAlias() {
        return 'ut';
    }
}