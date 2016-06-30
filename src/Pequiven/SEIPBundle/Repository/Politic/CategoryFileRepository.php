<?php

namespace Pequiven\SEIPBundle\Repository\Politic;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de categorias de archivos
 * @author Victor Tortolero vart10.30@gmail.com
 */
class CategoryFileRepository extends SeipEntityRepository {

    function findCategoryFile() {
        $qb = $this->getQueryBuilder();
        return $qb->getQuery()->getResult();
    }
    
    function findQueryCategoriesCET(array $criteria = array()) {
        $qb = $this->getQueryBuilder();
        $qb
                ->addSelect('cf')
                ->andWhere('cf.sectionFile = :sectionFile')
                ->setParameter('sectionFile', \Pequiven\SEIPBundle\Entity\Politic\CategoryFile::SECTION_CET)
        ;

        return $qb;
    }
    
    function findQueryCategoriesEXP(array $criteria = array()) {
        $qb = $this->getQueryBuilder();
        $qb
                ->addSelect('cf')
                ->andWhere('cf.sectionFile = :sectionFile')
                ->setParameter('sectionFile', \Pequiven\SEIPBundle\Entity\Politic\CategoryFile::SECTION_EXP)
        ;

        return $qb;
    }

    protected function getAlias() {
        return 'cf';
    }

}
