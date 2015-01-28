<?php

namespace Tecnocreaciones\Bundle\BoxBundle\Model;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Interface del box
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
interface BoxInterface extends ContainerAwareInterface
{
    function getName();
    
    function getDescription();
    
    function getTranslationDomain();
    
    function getParameters();
    
    function getTemplateName();
    
    function hasPermission();
    
    function getAssetsJs();
    
    function getAssetsCss();

    function getGroups();
    
    function getAreasNotPermitted();
    
    function getAreasPermitted();
}
