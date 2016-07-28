<?php

namespace Pequiven\TrelloBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Pequiven\TrelloBundle\Entity\Task;
use Pequiven\TrelloBundle\Form\TaskType;

class TrelloController extends Controller
{
    public function createAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            throw $this->createAccessDeniedException();
        }

        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $em = $this->get('app.connection_service')->getManager('master');

        switch($request->getMethod())
        {
            case 'POST':
                $task->setTitle($request->request->get('title'));
                $task->setDescription($request->request->get('desc'));
                $task->setCreatedBy($this->getUser());

                $em->persist($task);
                $em->flush();
                
                return redirectToRoute('create');
                
                break;

            case 'GET':
                $em = $this->getDoctrine()->getManager('master');

                $tasks = $em->getRepository('PequivenTrelloBundle:Task')
                            ->findBy(
                                array('status' => 0)
                            );

                $lists = $em->getRepository('PequivenTrelloBundle:Lists')
                            ->findAll();

                $users = $em->getRepository('PequivenTrelloBundle:User')
                            ->findTrelloUsers();

                return $this->render('PequivenTrelloBundle:create.html.twig', array(
                    'form' => $form->createView(),
                    'tasksList' => $tasks,
                    'mainList' => $lists,
                    'userList' => $users
                ));

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

        $em = $this->get('app.connection_service')->getManager('master');

        $task = $em->getRepository('PequivenTrelloBundle:Task')
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