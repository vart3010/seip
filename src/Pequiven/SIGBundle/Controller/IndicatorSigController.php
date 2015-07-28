<?php

namespace Pequiven\SIGBundle\Controller;

#use Symfony\Bundle\FrameworkBundle\Controller\Controller;
#use Pequiven\SEIPBundle\Controller\SEIPController;

#use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;

use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\SIGBundle\Entity\ManagementSystem;

use Symfony\Component\HttpFoundation\Request;
use Pequiven\ArrangementBundle\Entity\ArrangementRange;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Pequiven\IndicatorBundle\Entity\IndicatorLevel;
use Pequiven\SEIPBundle\Model\Common\CommonObject;

class IndicatorSigController extends ResourceController
{   
    /**
     * Lista de Indicadores por nivel(Estratégico, Táctico u Operativo)
     * 
     * @param Request $request
     * @return type
     */
    function listAction(Request $request) {

        $level = $request->get('level');        

        $rol = null;
        $roleByLevel = array(
            IndicatorLevel::LEVEL_ESTRATEGICO => array('ROLE_SEIP_INDICATOR_VIEW_STRATEGIC', 'ROLE_SEIP_PLANNING_LIST_INDICATOR_STRATEGIC'),
            IndicatorLevel::LEVEL_TACTICO => array('ROLE_SEIP_INDICATOR_VIEW_TACTIC', 'ROLE_SEIP_PLANNING_LIST_INDICATOR_TACTIC'),
            IndicatorLevel::LEVEL_OPERATIVO => array('ROLE_SEIP_INDICATOR_VIEW_OPERATIVE', 'ROLE_SEIP_PLANNING_LIST_INDICATOR_OPERATIVE')
        );
        if (isset($roleByLevel[$level])) {
            $rol = $roleByLevel[$level];
        }

        $this->getSecurityService()->checkSecurity($rol);
        

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();

        $criteria['indicatorLevel'] = $level;
        $criteria['applyPeriodCriteria'] = false;
            

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorByLevel', array($criteria, $sorting)
            );
        

            $maxPerPage = $this->config->getPaginationMaxPerPage();
            if (($limit = $request->query->get('limit')) && $limit > 0) {
                if ($limit > 100) {
                    $limit = 100;
                }
                $maxPerPage = $limit;
            }
            $resources->setCurrentPage($request->get('page', 1), true, true);
            $resources->setMaxPerPage($maxPerPage);
        } else {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'findBy', array($criteria, $sorting, $this->config->getLimit())
            );
        }
        $routeParameters = array(
            '_format' => 'json',
            'level' => $level,
        );
        $apiDataUrl = $this->generateUrl('pequiven_indicatorsig_list', $routeParameters);
        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('list.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;

        //var_dump($view);
        //die();
        
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'valuesIndicator','managementSystem','api_details', 'sonata_api_read', 'formula'));
        if ($request->get('_format') == 'html') {
            $labelsSummary = array();
            foreach (Indicator::getLabelsSummary() as $key => $value) {
                $labelsSummary[] = array(
                    'id' => $key,
                    'description' => $this->trans($value, array(), 'PequivenSIGBundle'),
                );
            }

            $data = array(
                'apiDataUrl' => $apiDataUrl,
                $this->config->getPluralResourceName() => $resources,
                'level' => $level,
                'labelsSummary' => $labelsSummary
            );
            $view->setData($data);

        } else {
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }
        //return $this->render('PequivenSIGBundle:Indicator:list.html.twig');
        return $this->handleView($view);

    }

    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SecurityService
     */
    protected function getSecurityService() {

        return $this->container->get('seip.service.security');
    }    
   
}