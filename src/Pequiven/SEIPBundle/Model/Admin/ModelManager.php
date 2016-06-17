<?php

namespace Pequiven\SEIPBundle\Model\Admin;

use PDOException;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager as BaseManager;

/**
 * Description of ModelManager
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class ModelManager extends BaseManager
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
            $originaObjects = $entityManager->getRepository(get_class($object))->findBy(array(
                'parent' => $object,
            ));
            
            $childrensObject = $object->getChildrens();
            foreach ($originaObjects as $indicatorChild) {
                $find = false;
                foreach ($childrensObject as $child) {
                    if($child === $indicatorChild){
                        $find = true;
                        break;
                    }
                }
                if($find === false){
                    $indicatorChild->setParent(null);
                    $entityManager->persist($indicatorChild);
                }
            }
            
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
                    if($mapping['fieldName'] != 'childrens'){
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
