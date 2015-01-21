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
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
interface BoxActiveInterface {
    
    function getDescription();
    
    function setDescription($description);
    
    function getBoxName();
    
    function setBoxName($boxName);
    
    function setAreasName($areasName);
    
    function getAreasName();
    
    function getTranslationDomain();
    
    function setTranslationDomain($translationDomain);
}
