<?php

namespace Pequiven\IndicatorBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Servicios para el indicador
 * 
 * @service pequiven_indicator.service.inidicator
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class IndicatorService implements ContainerAwareInterface
{
    private $container;
    
    public function calculateFormulaValue(\Pequiven\MasterBundle\Entity\Formula $formula,array $data) 
    {
        $variables = $formula->getVariables();
        foreach ($variables as $variable) {
            $name = $variable->getName();
            $$name = 0;
            if(isset($data[$name])){
                $$name = $data[$name];
            }
        }
        $equationParse = $this->parseFormulaVars($formula);
//        var_dump($equationParse);
        $result = 0;
        try {
            eval(sprintf('$result = %s;',$equationParse));
        } catch( \ErrorException $exc){
//            echo 'Excepción capturada 1 : ',  $e->getMessage(), "\n";
        } catch (\Exception $exc) {
//            echo $exc->getTraceAsString();
//            echo 'Excepción capturada 2: ',  $e->getMessage(), "\n";
            $result = 0;
        }

        return $result;
    }
    
    public function parseFormulaVars(\Pequiven\MasterBundle\Entity\Formula $formula) {
        $equationReal = $formula->getEquationReal();
        $variables = $formula->getVariables();
        $formulaPaser = $equationReal;
        foreach ($variables as $variable) {
            $name = $variable->getName();
            if(preg_match('/'.$name.'/i', $formulaPaser)){
                $formulaPaser = preg_replace('/'.$name.'/i', '$'.$name, $formulaPaser);
            }
        }
        return $formulaPaser;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
