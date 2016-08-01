<?php

namespace Pequiven\TrelloBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pequiven\TrelloBundle\Entity\TaskTrello;
use Pequiven\SEIPBundle\Controller\SEIPController;
use Pequiven\TrelloBundle\Form\TaskType;

class TrelloController extends SEIPController
{
    public function createAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            throw $this->createAccessDeniedException();
        }

        $task = new TaskTrello();
        $form = $this->createForm(TaskType::class, $task);

//        $em = $this->get('app.connection_service')->getManager('master');
        $em = $this->getDoctrine()->getManager();

        switch($request->getMethod())
        {
            case 'POST':
                $task->setTitle($request->request->get('title'));
                $task->setDescription($request->request->get('desc'));
                $task->setCreatedBy($this->getUser());

                $em->persist($task);
                $em->flush();
                
                $this->redirect($this->generateUrl("create_task_trello"));
                
                break;

            case 'GET':
//                $em = $this->getDoctrine()->getManager('master');
                $em = $this->getDoctrine()->getManager();

                $tasks = $em->getRepository('PequivenTrelloBundle:TaskTrello')
                            ->findBy(
                                array('status' => 0)
                            );

                $lists = $em->getRepository('PequivenTrelloBundle:ListTrello')
                            ->findAll();

                $users = $em->getRepository('PequivenTrelloBundle:UserTrello')
                            ->findTrelloUsers();
                
                $view = $this
                    ->view()
                    ->setTemplate($this->config->getTemplate('create.html'))
                    ->setData(array(
                        'form' => $form->createView(),
                        'tasksList' => $tasks,
                        'mainList' => $lists,
                        'userList' => $users
                    ))
                ;

                //$groups = array_merge(array('id','api_list','gerencia','gerenciaSecond'), $request->get('_groups',array()));
                //$view->getSerializationContext()->setGroups($groups);
                return $this->handleView($view);

                break;
        }
    }

    public function updateAction(Request $request)
    {
        //cambiar a multiples usuarios
        $membersArray = array($request->request->get('memberId'));

        $array = array(
                'taskId' => $request->request->get('taskId'),
                'cardTitle' => $request->request->get('taskTitle'),
                'cardDescription' => $request->request->get('taskDesc'),
                'listID' => $request->request->get('listId'),
                'memberIDs' => $membersArray
            );

//        $em = $this->get('app.connection_service')->getManager('master');
        $em = $this->getDoctrine()->getManager();

        $task = $em->getRepository('PequivenTrelloBundle:TaskTrello')
                   ->findOneById($array['taskId']);

        if (!$task) {
            throw $this->createNotFoundException(
                'No existe la actividad para el id '.$array['taskId']
            );
        }

        $task->setStatus(1);
        $em->flush();

        return new JsonResponse($array);       
    }
}