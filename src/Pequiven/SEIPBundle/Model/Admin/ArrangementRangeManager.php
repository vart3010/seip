<?php

namespace Pequiven\SEIPBundle\Model\Admin;

use PDOException;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager as BaseManager;

/**
    * Description of ArrangementRangeManager
 *
 */
class ArrangementRangeManager extends BaseManager
{
    /**
     * {@inheritdoc}
     */
    public function create($object)
    {
        try {
            $entityManager = $this->getEntityManager($object);
            $entityManager->persist($object);
            $entityManager->flush();
            $this->persistAssociations($object);
        } catch (PDOException $e) {
            throw new ModelManagerException('', 0, $e);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function update($object)
    {       
        try {
            $entityManager = $this->getEntityManager($object);
            
            $entityManager->persist($object);
            $entityManager->flush();
            $this->persistAssociations($object);
        } catch (PDOException $e) {
            throw new ModelManagerException('', 0, $e);
        }
    }

    /**
     * Persist owning side associations
     */
    public function persistAssociations($object)
    {       
        $associations = $this
            ->getMetadata(get_class($object))
            ->getAssociationMappings();

        if ($associations) {
            $entityManager = $this->getEntityManager($object);

            foreach ($associations as $field => $mapping) {
                if ($mapping['isOwningSide'] == false) {
                    if($mapping['fieldName'] != 'indicator' || $mapping['fieldName'] != 'objetive'){
                        continue;
                    }
                    
                    if ($owningObjects = $object->{'get' . ucfirst($mapping['fieldName'])}()) {
                        foreach ($owningObjects as $owningObject) {
                            $owningObject->{'set' . ucfirst($mapping['mappedBy']) }($object);
                            $entityManager->persist($owningObject);
                        }
                        $entityManager->flush();
                    }
                }
            }
        }
    }
}
