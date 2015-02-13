<?php

namespace Pequiven\ArrangementBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use ErrorException;
use Exception;
use LogicException;
use Pequiven\ArrangementBundle\Entity\ArrangementRange;
use Pequiven\MasterBundle\Entity\Tendency;
use Pequiven\MasterBundle\Entity\ArrangementRangeType;
use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\MasterBundle\Entity\Formula;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Servicios para el rango de gestión
 * 
 * @service pequiven_arrangement.service.arrangementrange
 */
class ArrangementRangeService implements ContainerAwareInterface
{
    private $container;
    
    public function validateArrangementRange(ArrangementRange $arrangementRange, Tendency $tendency){
        $error = null;
        $tendencyArray = Tendency::getLabelsSummary();
        
        if($tendency->getRef() == Tendency::TENDENCY_EST){
            if(!($arrangementRange->getRankBottomMixedBottom()) || !($arrangementRange->getRankBottomMixedTop()) || !($arrangementRange->getRankMiddleBottomMixedTop()) || !($arrangementRange->getRankMiddleBottomMixedBottom()) || !($arrangementRange->getRankMiddleTopMixedTop()) || !($arrangementRange->getRankMiddleTopMixedBottom()) || !($arrangementRange->getRankTopMixedTop()) || !($arrangementRange->getRankTopMixedBottom())){//Si algun valor de los llamados a ser estables está nulo
                $error = $this->trans('pequiven_arrangementRange.rangeIsBadDefined', array('%tendencia%' => $this->trans($tendencyArray[Tendency::TENDENCY_EST], array(), 'PequivenArrangementBundle')), 'PequivenArrangementBundle');
            } elseif($arrangementRange->getRankTopMixedBottom() <= $arrangementRange->getRankTopMixedTop()){//Rango Alto Alto menor que Rango Alto Bajo
                $error = $this->trans('pequiven_arrangementRange.rangeTopIsBadDefined', array(), 'PequivenArrangementBundle');
            } elseif($arrangementRange->getRankMiddleBottomMixedBottom() <= $arrangementRange->getRankMiddleBottomMixedTop()){//Rango Medio Bajo Alto menor que Rango Medio Bajo Bajo
                $error = $this->trans('pequiven_arrangementRange.rangeMiddleBottomIsBadDefined', array(), 'PequivenArrangementBundle');
            } elseif($arrangementRange->getRankMiddleTopMixedBottom() <= $arrangementRange->getRankMiddleTopMixedTop()){//Rango Medio Alto Alto menor que Rango Medio Alto Bajo
                $error = $this->trans('pequiven_arrangementRange.rangeMiddleTopIsBadDefined', array(), 'PequivenArrangementBundle');
            } elseif($arrangementRange->getRankBottomMixedBottom() <= $arrangementRange->getRankBottomMixedTop()){//Rango Bajo Alto menor que Rango Bajo Bajo
                $error = $this->trans('pequiven_arrangementRange.rangeBottomIsBadDefined', array(), 'PequivenArrangementBundle');
            } elseif($arrangementRange->getRankMiddleTopMixedTop() <= $arrangementRange->getRankTopMixedTop() || $arrangementRange->getRankMiddleTopMixedBottom() <= $arrangementRange->getRankTopMixedTop() || $arrangementRange->getRankMiddleTopMixedTop() < $arrangementRange->getRankTopMixedBottom() || $arrangementRange->getRankMiddleTopMixedBottom() < $arrangementRange->getRankTopMixedBottom()){//Rango Medio Alto menor que Rango Alto Bajo
                $error = $this->trans('pequiven_arrangementRange.rangeMiddleTopLessThanTopStable', array(), 'PequivenArrangementBundle');
            } elseif($arrangementRange->getRankMiddleBottomMixedTop() >= $arrangementRange->getRankTopMixedBottom() || $arrangementRange->getRankMiddleBottomMixedBottom() >= $arrangementRange->getRankTopMixedBottom() || $arrangementRange->getRankMiddleBottomMixedTop() > $arrangementRange->getRankTopMixedTop() || $arrangementRange->getRankMiddleBottomMixedBottom() > $arrangementRange->getRankTopMixedTop()){//Rango Medio Bajo mayor que Rango Alto Alto
                $error = $this->trans('pequiven_arrangementRange.rangeMiddleBottomHigherThanTopStable', array(), 'PequivenArrangementBundle');
            } elseif($arrangementRange->getRankBottomMixedTop() < $arrangementRange->getRankMiddleTopMixedBottom() || $arrangementRange->getRankBottomMixedTop() < $arrangementRange->getRankMiddleTopMixedTop() || $arrangementRange->getRankBottomMixedTop() < $arrangementRange->getRankTopMixedBottom() || $arrangementRange->getRankBottomMixedTop() < $arrangementRange->getRankTopMixedBottom() || $arrangementRange->getRankTopMixedTop() < $arrangementRange->getRankMiddleBottomMixedBottom() || $arrangementRange->getRankTopMixedTop() < $arrangementRange->getRankMiddleBottomMixedTop()){//El rango bajo alto esta mál definido
                $error = $this->trans('pequiven_arrangementRange.rangeBottomTopLessThanStable', array(), 'PequivenArrangementBundle');
            } elseif($arrangementRange->getRankBottomMixedBottom() > $arrangementRange->getRankMiddleTopMixedBottom() || $arrangementRange->getRankBottomMixedBottom() > $arrangementRange->getRankMiddleTopMixedTop() || $arrangementRange->getRankBottomMixedBottom() > $arrangementRange->getRankTopMixedBottom() || $arrangementRange->getRankBottomMixedBottom() > $arrangementRange->getRankTopMixedBottom() || $arrangementRange->getRankTopMixedBottom() > $arrangementRange->getRankMiddleBottomMixedBottom() || $arrangementRange->getRankTopMixedBottom() > $arrangementRange->getRankMiddleBottomMixedTop()){//El rango bajo bajo esta mál definido
                $error = $this->trans('pequiven_arrangementRange.rangeBottomBottomHigherThanStable', array(), 'PequivenArrangementBundle');
            }
        } elseif($tendency->getRef() == Tendency::TENDENCY_MAX || $tendency->getRef() == Tendency::TENDENCY_MIN){
            $arrangementRangeTypeArray = ArrangementRangeType::getRefsSummary();
            if(($arrangementRange->getTypeRangeTop()->getRef() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_TOP_BASIC] && !($arrangementRange->getRankTopBasic())) || ($arrangementRange->getTypeRangeTop()->getRef() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_TOP_MIXED] && (!($arrangementRange->getRankTopMixedTop()) || !($arrangementRange->getRankTopMixedBottom())))){//El rango alto esta mal definido
                $error = $this->trans('pequiven_arrangementRange.rangeIsBadDefined', array('%tendencia%' => $this->trans($tendencyArray[Tendency::TENDENCY_MAX], array(), 'PequivenArrangementBundle')), 'PequivenArrangementBundle').'. '.$this->trans('pequiven_arrangementRange.rangeTopIsBadDefined', array(), 'PequivenArrangementBundle');
            } elseif(($arrangementRange->getTypeRangeMiddleTop()->getRef() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_BASIC] && !($arrangementRange->getRankMiddleTopBasic())) || ($arrangementRange->getTypeRangeMiddleTop()->getRef() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_MIXED] && (!($arrangementRange->getRankMiddleTopMixedTop()) || !($arrangementRange->getRankMiddleTopMixedBottom())))){//El rango medio alto está mal definido
                $error = $this->trans('pequiven_arrangementRange.rangeIsBadDefined', array('%tendencia%' => $this->trans($tendencyArray[Tendency::TENDENCY_MAX], array(), 'PequivenArrangementBundle')), 'PequivenArrangementBundle').'. '.$this->trans('pequiven_arrangementRange.rangeMiddleTopIsBadDefined', array(), 'PequivenArrangementBundle');
            } elseif(($arrangementRange->getTypeRangeMiddleBottom()->getRef() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_BASIC] && !($arrangementRange->getRankMiddleBottomBasic())) || ($arrangementRange->getTypeRangeMiddleBottom()->getRef() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_MIXED] && (!($arrangementRange->getRankMiddleBottomMixedTop()) || !($arrangementRange->getRankMiddleBottomMixedBottom())))){//El rango medio bajo está mal definido
                $error = $this->trans('pequiven_arrangementRange.rangeIsBadDefined', array('%tendencia%' => $this->trans($tendencyArray[Tendency::TENDENCY_MAX], array(), 'PequivenArrangementBundle')), 'PequivenArrangementBundle').'. '.$this->trans('pequiven_arrangementRange.rangeMiddleBottomIsBadDefined', array(), 'PequivenArrangementBundle');
            } elseif(($arrangementRange->getTypeRangeBottom()->getRef() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_BASIC] && !($arrangementRange->getRankBottomBasic())) || ($arrangementRange->getTypeRangeBottom()->getRef() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_MIXED] && (!($arrangementRange->getRankBottomMixedTop()) || !($arrangementRange->getRankBottomMixedBottom())))){//El rango bajo está mal definido
                $error = $this->trans('pequiven_arrangementRange.rangeIsBadDefined', array('%tendencia%' => $this->trans($tendencyArray[Tendency::TENDENCY_MAX], array(), 'PequivenArrangementBundle')), 'PequivenArrangementBundle').'. '.$this->trans('pequiven_arrangementRange.rangeBottomIsBadDefined', array(), 'PequivenArrangementBundle');
            } elseif($arrangementRange->getTypeRangeTop() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_TOP_BASIC]){//Si el rango alto es menor que los otros rangos
                if($arrangementRange->getTypeRangeMiddleTop() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_BASIC]){
                    if($arrangementRange->getRankTopBasic() < $arrangementRange->getRankMiddleTopBasic()){
                        $error = $this->trans('pequiven_arrangementRange.rangeTopLessThan', array(), 'PequivenArrangementBundle');
                    }
                } elseif($arrangementRange->getTypeRangeMiddleTop() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_MIXED]){
                    if($arrangementRange->getRankTopBasic() < $arrangementRange->getRankMiddleTopMixedTop() || $arrangementRange->getRankTopBasic() < $arrangementRange->getRankMiddleTopMixedBottom()){
                        $error = $this->trans('pequiven_arrangementRange.rangeTopLessThan', array(), 'PequivenArrangementBundle');
                    }
                } elseif($arrangementRange->getTypeRangeMiddleBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_BASIC]){
                    if($arrangementRange->getRankTopBasic() < $arrangementRange->getRankMiddleBottomBasic()){
                        $error = $this->trans('pequiven_arrangementRange.rangeTopLessThan', array(), 'PequivenArrangementBundle');
                    }
                } elseif($arrangementRange->getTypeRangeMiddleBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_MIXED]){
                    if($arrangementRange->getRankTopBasic() < $arrangementRange->getRankMiddleBottomMixedTop() || $arrangementRange->getRankTopBasic() < $arrangementRange->getRankMiddleBottomMixedBottom()){
                        $error = $this->trans('pequiven_arrangementRange.rangeTopLessThan', array(), 'PequivenArrangementBundle');
                    }
                } elseif($arrangementRange->getTypeRangeBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_BASIC]){
                    if($arrangementRange->getRankTopBasic() < $arrangementRange->getRankBottomBasic()){
                        $error = $this->trans('pequiven_arrangementRange.rangeTopLessThan', array(), 'PequivenArrangementBundle');
                    }
                } elseif($arrangementRange->getTypeRangeBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_MIXED]){
                    if($arrangementRange->getRankTopBasic() < $arrangementRange->getRankBottomMixedTop() || $arrangementRange->getRankTopBasic() < $arrangementRange->getRankBottomMixedBottom()){
                        $error = $this->trans('pequiven_arrangementRange.rangeTopLessThan', array(), 'PequivenArrangementBundle');
                    }
                }
            } elseif($arrangementRange->getTypeRangeTop() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_TOP_MIXED]){//Si el rango alto es menor que los otros rangos
                if($arrangementRange->getTypeRangeMiddleTop() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_BASIC]){
                    if($arrangementRange->getRankTopMixedTop() < $arrangementRange->getRankMiddleTopBasic() || $arrangementRange->getRankTopMixedBottom() < $arrangementRange->getRankMiddleTopBasic()){
                        $error = $this->trans('pequiven_arrangementRange.rangeTopLessThan', array(), 'PequivenArrangementBundle');
                    }
                } elseif($arrangementRange->getTypeRangeMiddleTop() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_MIXED]){
                    if($arrangementRange->getRankTopMixedTop() < $arrangementRange->getRankMiddleTopMixedTop() || $arrangementRange->getRankTopMixedTop() < $arrangementRange->getRankMiddleTopMixedBottom() || $arrangementRange->getRankTopMixedBottom() < $arrangementRange->getRankMiddleTopMixedTop() || $arrangementRange->getRankTopMixedBottom() < $arrangementRange->getRankMiddleTopMixedBottom()){
                        $error = $this->trans('pequiven_arrangementRange.rangeTopLessThan', array(), 'PequivenArrangementBundle');
                    }
                } elseif($arrangementRange->getTypeRangeMiddleBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_BASIC]){
                    if($arrangementRange->getRankTopMixedTop() < $arrangementRange->getRankMiddleBottomBasic() || $arrangementRange->getRankTopMixedBottom() < $arrangementRange->getRankMiddleBottomBasic()){
                        $error = $this->trans('pequiven_arrangementRange.rangeTopLessThan', array(), 'PequivenArrangementBundle');
                    }
                } elseif($arrangementRange->getTypeRangeMiddleBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_MIXED]){
                    if($arrangementRange->getRankTopMixedTop() < $arrangementRange->getRankMiddleBottomMixedTop() || $arrangementRange->getRankTopMixedTop() < $arrangementRange->getRankMiddleBottomMixedBottom() || $arrangementRange->getRankTopMixedBottom() < $arrangementRange->getRankMiddleBottomMixedTop() || $arrangementRange->getRankTopMixedBottom() < $arrangementRange->getRankMiddleBottomMixedBottom()){
                        $error = $this->trans('pequiven_arrangementRange.rangeTopLessThan', array(), 'PequivenArrangementBundle');
                    }
                } elseif($arrangementRange->getTypeRangeBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_BASIC]){
                    if($arrangementRange->getRankTopMixedTop() < $arrangementRange->getRankBottomBasic() || $arrangementRange->getRankTopMixedBottom() < $arrangementRange->getRankBottomBasic()){
                        $error = $this->trans('pequiven_arrangementRange.rangeTopLessThan', array(), 'PequivenArrangementBundle');
                    }
                } elseif($arrangementRange->getTypeRangeBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_MIXED]){
                    if($arrangementRange->getRankTopMixedTop() < $arrangementRange->getRankBottomMixedTop() || $arrangementRange->getRankTopMixedTop() < $arrangementRange->getRankBottomMixedBottom() || $arrangementRange->getRankTopMixedBottom() < $arrangementRange->getRankBottomMixedTop() || $arrangementRange->getRankTopMixedBottom() < $arrangementRange->getRankBottomMixedBottom()){
                        $error = $this->trans('pequiven_arrangementRange.rangeTopLessThan', array(), 'PequivenArrangementBundle');
                    }
                }
            } elseif($arrangementRange->getTypeRangeMiddleTop() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_BASIC]){//Si el rango medio alto es menor que los otros rangos inferiores
                if($arrangementRange->getTypeRangeMiddleBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_BASIC]){
                    if($arrangementRange->getRankMiddleTopBasic() < $arrangementRange->getRankMiddleBottomBasic()){
                        $error = $this->trans('pequiven_arrangementRange.rangeMiddleTopLessThan', array(), 'PequivenArrangementBundle');
                    }
                } elseif($arrangementRange->getTypeRangeMiddleBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_MIXED]){
                    if($arrangementRange->getRankMiddleTopBasic() < $arrangementRange->getRankMiddleBottomMixedTop() || $arrangementRange->getRankMiddleTopBasic() < $arrangementRange->getRankMiddleBottomMixedBottom()){
                        $error = $this->trans('pequiven_arrangementRange.rangeMiddleTopLessThan', array(), 'PequivenArrangementBundle');
                    }
                } elseif($arrangementRange->getTypeRangeBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_BASIC]){
                    if($arrangementRange->getRankMiddleTopBasic() < $arrangementRange->getRankBottomBasic()){
                        $error = $this->trans('pequiven_arrangementRange.rangeMiddleTopLessThan', array(), 'PequivenArrangementBundle');
                    }
                } elseif($arrangementRange->getTypeRangeBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_MIXED]){
                    if($arrangementRange->getRankMiddleTopBasic() < $arrangementRange->getRankBottomMixedTop() || $arrangementRange->getRankMiddleTopBasic() < $arrangementRange->getRankBottomMixedBottom()){
                        $error = $this->trans('pequiven_arrangementRange.rangeMiddleTopLessThan', array(), 'PequivenArrangementBundle');
                    }
                }
            } elseif($arrangementRange->getTypeRangeMiddleTop() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_MIXED]){//Si el rango medio alto es menor que los otros rangos inferiores
                if($arrangementRange->getTypeRangeMiddleBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_BASIC]){
                    if($arrangementRange->getRankMiddleTopMixedTop() < $arrangementRange->getRankMiddleBottomBasic() || $arrangementRange->getRankMiddleTopMixedBottom() < $arrangementRange->getRankMiddleBottomBasic()){
                        $error = $this->trans('pequiven_arrangementRange.rangeMiddleTopLessThan', array(), 'PequivenArrangementBundle');
                    }
                } elseif($arrangementRange->getTypeRangeMiddleBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_MIXED]){
                    if($arrangementRange->getRankMiddleTopMixedTop() < $arrangementRange->getRankMiddleBottomMixedTop() || $arrangementRange->getRankMiddleTopMixedTop() < $arrangementRange->getRankMiddleBottomMixedBottom() || $arrangementRange->getRankMiddleTopMixedBottom() < $arrangementRange->getRankMiddleBottomMixedTop() || $arrangementRange->getRankMiddleTopMixedBottom() < $arrangementRange->getRankMiddleBottomMixedBottom()){
                        $error = $this->trans('pequiven_arrangementRange.rangeMiddleTopLessThan', array(), 'PequivenArrangementBundle');
                    }
                } elseif($arrangementRange->getTypeRangeBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_BASIC]){
                    if($arrangementRange->getRankMiddleTopMixedTop() < $arrangementRange->getRankBottomBasic() || $arrangementRange->getRankMiddleTopMixedBottom() < $arrangementRange->getRankBottomBasic()){
                        $error = $this->trans('pequiven_arrangementRange.rangeMiddleTopLessThan', array(), 'PequivenArrangementBundle');
                    }
                } elseif($arrangementRange->getTypeRangeBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_MIXED]){
                    if($arrangementRange->getRankMiddleTopMixedTop() < $arrangementRange->getRankBottomMixedTop() || $arrangementRange->getRankMiddleTopMixedTop() < $arrangementRange->getRankBottomMixedBottom() || $arrangementRange->getRankMiddleTopMixedBottom() < $arrangementRange->getRankBottomMixedTop() || $arrangementRange->getRankMiddleTopMixedBottom() < $arrangementRange->getRankBottomMixedBottom()){
                        $error = $this->trans('pequiven_arrangementRange.rangeMiddleTopLessThan', array(), 'PequivenArrangementBundle');
                    }
                }
            } elseif($arrangementRange->getTypeRangeMiddleBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_BASIC]){//Si el rango medio bajo es menor que los otros rangos inferiores
                if($arrangementRange->getTypeRangeBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_BASIC]){
                    if($arrangementRange->getRankMiddleBottomBasic() < $arrangementRange->getRankBottomBasic()){
                        $error = $this->trans('pequiven_arrangementRange.rangeMiddleBottomLessThan', array(), 'PequivenArrangementBundle');
                    }
                } elseif($arrangementRange->getTypeRangeBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_MIXED]){
                    if($arrangementRange->getRankMiddleBottomBasic() < $arrangementRange->getRankBottomMixedTop() || $arrangementRange->getRankMiddleBottomBasic() < $arrangementRange->getRankBottomMixedBottom()){
                        $error = $this->trans('pequiven_arrangementRange.rangeMiddleBottomLessThan', array(), 'PequivenArrangementBundle');
                    }
                }
            } elseif($arrangementRange->getTypeRangeMiddleBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_MIXED]){//Si el rango medio bajo es menor que los otros rangos inferiores
                if($arrangementRange->getTypeRangeBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_BASIC]){
                    if($arrangementRange->getRankMiddleBottomMixedTop() < $arrangementRange->getRankBottomBasic() || $arrangementRange->getRankMiddleBottomMixedBottom() < $arrangementRange->getRankBottomBasic()){
                        $error = $this->trans('pequiven_arrangementRange.rangeMiddleBottomLessThan', array(), 'PequivenArrangementBundle');
                    }
                } elseif($arrangementRange->getTypeRangeBottom() == $arrangementRangeTypeArray[ArrangementRangeType::RANGE_TYPE_BOTTOM_MIXED]){
                    if($arrangementRange->getRankMiddleBottomMixedTop() < $arrangementRange->getRankBottomMixedTop() || $arrangementRange->getRankMiddleBottomMixedTop() < $arrangementRange->getRankBottomMixedBottom() || $arrangementRange->getRankMiddleBottomMixedBottom() < $arrangementRange->getRankBottomMixedTop() || $arrangementRange->getRankMiddleBottomMixedBottom() < $arrangementRange->getRankBottomMixedBottom()){
                        $error = $this->trans('pequiven_arrangementRange.rangeMiddleBottomLessThan', array(), 'PequivenArrangementBundle');
                    }
                }
            }
        }
        
        return $error;
    }
    
    /**
     * Servicio que calcula los resultados
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    public function getResultService()
    {
        return $this->container->get('seip.service.result');
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    protected function trans($id,array $parameters = array(), $domain = 'messages')
    {
        return $this->container->get('translator')->trans($id, $parameters, $domain);
    }
    
    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return Registry
     *
     * @throws LogicException If DoctrineBundle is not available
     */
    public function getDoctrine()
    {
        if (!$this->container->has('doctrine')) {
            throw new LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }
}
