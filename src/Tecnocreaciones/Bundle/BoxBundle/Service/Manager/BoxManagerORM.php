<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tecnocreaciones\Bundle\BoxBundle\Service\Manager;

/**
 * Manejador de box por ORM y usuario
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class BoxManagerORM extends BoxManager {
    
    function find($boxName, $areaName)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository($this->classBox);
        $box = $repository->findOneBy(array(
            'user' => $user,
            'boxName' => $boxName,
            'areaName' => $areaName
        ));
        return $box;
    }
    
    public function remove(\Tecnocreaciones\Bundle\BoxBundle\Model\ModelBoxInterface $box) 
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($box);
        $em->flush();
    }

    public function save($boxName, $areasName) 
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        
        foreach ($areasName as $key => $areaName) {
            $areasName[$areaName] = 0;
            unset($areasName[$key]);
        }
        $modelBox = $this->createNew();
        $modelBox
                ->setAreaName($areasName)
                ->setBoxName($boxName)
                ;
        $modelBox->setUser($user);
        
        $em->persist($modelBox);
        $em->flush();
        
        return $modelBox;
    }
}
