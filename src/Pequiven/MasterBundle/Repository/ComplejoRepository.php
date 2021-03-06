<?php

namespace Pequiven\MasterBundle\Repository;

use Tecnocreaciones\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * ComplejoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ComplejoRepository extends EntityRepository
{
    function getByGerencia(){
        $data = array();
        
        $container = \Pequiven\MasterBundle\PequivenMasterBundle::getContainer();
        $securityContext = $container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $em = $this->getEntityManager();
        
        
        $gerencias = $this->get('pequiven.repository.gerenciafirst')->findBy(array('ref' => $user->getGerencia()->getRef()));
        $complejosList = '';
        $i = 1;
        $total = count($gerencias);
        foreach($gerencias as $gerencia){
            if($i == $total){
                $complejosList.= $gerencia->getComplejo()->getId();
            } else{
                $complejosList.= $gerencia->getComplejo()->getId().',';
            }
            $i++;
        }
        
        $query = $em->createQueryBuilder()
                        ->select('c')
                        ->from('\Pequiven\MasterBundle\Entity\Complejo', 'c')
                        ->andWhere('c.enabled = ' . 1)
                        ->andWhere('c.id IN ('.$complejosList.')')
                ;
        

        
        
        
        $complejos = $query->getQuery()
                           ->getResult();
        
//        foreach($complejos as $complejo){
//            if(!$gerencia->getComplejo()){
//                continue;
//            } 
//            if(!array_key_exists($gerencia->getComplejo()->getDescription(), $data)){
//                $data[$gerencia->getComplejo()->getDescription()] = array();
//            }
//            
//            $data[$gerencia->getComplejo()->getDescription()][$gerencia->getId()] = $gerencia;
//        }
        
        return $complejos;
    }
    
    function findComplejos(array $criteria = array()) {
        $qb = $this->getQueryBuilder();
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        if(($complejo = $criteria->remove('id'))){
            $qb
                    ->andWhere('c.id = :complejo')
                    ->setParameter('complejo', $complejo)
                ;
        }
        return $qb->getQuery()->getResult();
    }
    
    protected function getAlias() {
        return 'c';
    }
}