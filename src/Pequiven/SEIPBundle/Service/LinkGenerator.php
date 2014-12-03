<?php

namespace Pequiven\SEIPBundle\Service;

use LogicException;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Exception;

/**
 * Generador de links por objeto
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
abstract class LinkGenerator implements ContainerAwareInterface,  LinkGeneratorInterface
{
    /**
     * Contenedor de dependencias
     * @var ContainerInterface
     */
    protected $container;
    
    /**
     * Tipo de link por defecto o categoria (Se usa para crear links diferentes del mismo objeto)
     */
    const TYPE_LINK_DEFAULT = 0;
    
    /**
     * Configuraciones de las entitades
     * @var array
     */
    private $configsObjects = array();
    
    /**
     * Se usa para evaluar si ya se inicializo el generador
     * @var boolean
     */
    private $init = false;

    /**
     * Genera la configuracion de los objetos agreagados
     * @throws LogicException
     */
    private function boot (){
        $this->init = true;
        
        $configsObjectsDeft = $this->getConfigObjects();
        $defaultConfig = array(
            'type' => self::TYPE_LINK_DEFAULT,
            'icon' => 'fa fa-2x fa-flag',
            'method' => 'renderDefault',
            'routeParameters' => array(),
            'labelMethod' => null,
        );
        $configsObjects = array();
        foreach ($configsObjectsDeft as $key => $configObject)
        {
            $config = array_merge($defaultConfig,$configObject);
            if(!isset($config['class'])){
                throw new LogicException(sprintf('The class for item "%s" not defined',$key));
            }
            $class = $config['class'];
            if(!isset($config[$class])){
                $configsObjects[$class] = array();
            }
            $type = $config['type'];
            if(!isset($configsObjects[$class]['type'])){
                $configsObjects[$class]['type'] = array();
            }else{
                if(in_array($type, $configsObjects[$class]['type'])){
                    throw new LogicException(sprintf('The type "%s" for the class "%s" in item "%s" is already defined (Change type o remove definition)',$type,$class,$key));
                }
            }
            if($defaultConfig['method'] == $config['method'] && !isset($configObject['route'])){
                throw new LogicException(sprintf('The route for the class "%s" in item "%s" is required (optional with custom method)',$class,$key));
            }
            
            $configsObjects[$class]['type'][$type] = $config;
        }
        
        $this->configsObjects = $configsObjects;
    }
    
    /**
     * Metodo que renderiza el link por defecto
     * 
     * @param type $entity
     * @param type $entityConfig
     * @param type $type
     * @return type
     */
    protected function renderDefault($entity,$entityConfig,$type = self::TYPE_LINK_DEFAULT)
    {
        $route = $entityConfig['route'];
        $routeParameters = $entityConfig['routeParameters'];
        $labelMethod = $entityConfig['labelMethod'];
        
        if($labelMethod !== null){
            $label = call_user_func_array($entity, $labelMethod,array());
        }else{
            $label = (string)$entity;
        }
        
        $icon = sprintf('<i class="%s"></i>',$entityConfig['icon']);
        $href = $this->generateUrl($route,array_merge($routeParameters,array('id' => $entity->getId())));
        $link = sprintf('<a href="%s">%s&nbsp;&nbsp;%s</a>',$href,$icon,$label);
        
        return $link;
    }
    
    /**
     * Retorna la configuracion de una entidad u objeto
     * @param type $entity
     * @return type
     * @throws Exception
     */
    protected function getEntityConf($entity)
    {
        if($this->init === false){
            $this->boot();
        }
        if(preg_match('/'. \Doctrine\Common\Persistence\Proxy::MARKER .'/',$entity)){
            $entity = \Doctrine\Common\Util\ClassUtils::getRealClass($entity);
        }
        if(!isset($this->configsObjects[$entity])){
            throw new Exception(sprintf('The config for entity "%s", not defined',$entity));
        }
        return $this->configsObjects[$entity];
    }
    
    /**
     * Genera un link a partir de la configuracion de ese objeto
     * @param type $entity
     * @param array $entityConfig
     * @param type $type
     * @return type
     */
    private function generateFromConfig($entity,array $entityConfig,$type)
    {
        $method = $entityConfig['type'][$type]['method'];
        return call_user_func_array(array($this,$method), array($entity,$entityConfig['type'][$type],$type,$entityConfig));
    }

    /**
     * Genera el link del objeto
     * 
     * @param type $entity
     * @param type $type
     * @return type
     */
    public function generate($entity,$type = self::TYPE_LINK_DEFAULT)
    {
        $entityClass = get_class($entity);
        
        $entityConfig = $this->getEntityConf($entityClass);
        $link = '';
        if($entityConfig){
            $link = $this->generateFromConfig($entity,$entityConfig,$type);
        }
        return $link;
    }
    
    /**
     * Generates a URL from the given parameters.
     *
     * @param string         $route         The name of the route
     * @param mixed          $parameters    An array of parameters
     * @param bool|string    $referenceType The type of reference (one of the constants in UrlGeneratorInterface)
     *
     * @return string The generated URL
     *
     * @see UrlGeneratorInterface
     */
    protected function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->container->get('router')->generate($route, $parameters, $referenceType);
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
