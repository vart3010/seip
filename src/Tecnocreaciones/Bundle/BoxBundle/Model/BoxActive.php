<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tecnocreaciones\Bundle\BoxBundle\Model;

/**
 * Description of UserBoxActive
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class BoxActive implements BoxActiveInterface 
{
    private $areasName;
    
    private $boxName;
    
    private $description;
    
    private $translationDomain;
    
    function getAreasName() {
        return $this->areasName;
    }

    function setAreasName($areasName) {
        $this->areasName = $areasName;
    }
    
    function getDescription() {
        return $this->description;
    }

    function setDescription($description) {
        $this->description = $description;
    }
    
    function getTranslationDomain() {
        return $this->translationDomain;
    }

    function setTranslationDomain($translationDomain) {
        $this->translationDomain = $translationDomain;
    }
    
    function getBoxName() {
        return $this->boxName;
    }

    function setBoxName($boxName) {
        $this->boxName = $boxName;
    }
}
