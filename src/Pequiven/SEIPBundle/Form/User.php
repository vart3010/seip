<?php

namespace Pequiven\SEIPBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Pequiven\SEIPBundle\Model\Common\CommonObject;
use Pequiven\MasterBundle\Repository\RolRepository;
use Symfony\Component\Form\FormBuilder;
/**
 * Description of User
 *
 * @author matias
 */
class User extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $parametersUser = array(
            'class' => 'Pequiven\MasterBundle\Entity\Rol',
            'query_builder' =>
            function(RolRepository $qb) {
                return $qb->FindQBRolNotAdmin();
            },
            'property' => 'description',
            'label' => 'Grupos de Roles',
            'attr' => array(
                'class' => 'select2 input-xlarge'
            ),
            'multiple' => true
        );

        $builder
                ->add('username', null, array(
                    'label' => 'Usuario',
                    'attr' => array('class' => 'input input-medium')))
                ->add('firstname', null, array(
                    'label' => 'pequiven_seip.firstname',
                    'translation_domain' => 'PequivenSEIPBundle',
                    'attr' => array('class' => 'input input-medium')))
                ->add('lastname', null, array(
                    'label' => 'pequiven_seip.lastname',
                    'translation_domain' => 'PequivenSEIPBundle',
                    'attr' => array('class' => 'input input-medium')))
                ->add('numPersonal', null, array(
                    'label' => 'pequiven_seip.numPersonal',
                    'translation_domain' => 'PequivenSEIPBundle',
                    'attr' => array('class' => 'input input-small')))
                ->add('identification', null, array(
                    'label' => 'Cédula',
                    'attr' => array('class' => 'input input-small')))
                ->add('cellphone', 'text', array(
                    'label' => 'Teléfono Celular',
                    'required' => false,
                    'attr' => array('class' => 'input input-small')))
                ->add('ext', 'text', array(
                    'label' => 'Extensión',
                    'attr' => array('class' => 'input input-small'),
                    'required' => false))
                ->add('complejo', 'entity', array(
                    'class' => 'Pequiven\MasterBundle\Entity\Complejo',
                    'property' => 'description', 'required' => false,
                    'empty_data' => null,
                    'empty_value' => 'Ninguna',
                    'label' => 'pequiven_seip.complejo',
                    'translation_domain' => 'PequivenSEIPBundle',
                    'attr' => array('class' => 'select2 input-xlarge')))
                ->add('gerencia', 'entity', array(
                    'class' => 'Pequiven\MasterBundle\Entity\Gerencia',
                    'property' => 'description',
                    'required' => false,
                    'empty_data' => null,
                    'empty_value' => 'Ninguna',
                    'label' => 'Gerencia de 1ra Línea',
                    'attr' => array('class' => 'select2 input-xlarge')))
                ->add('locked', 'checkbox', array(
                    'label' => 'Bloqueado',
                    'required' => false))
                ->add('affiliatedWorker', 'checkbox', array(
                    'label' => 'Empresa Filial o Mixta',
                    'required' => false))
                ->add('statusWorker', 'choice', array(
                    'label' => 'Estatus',
                    'choices' => CommonObject::getLabelsStatusWorker(),
                    'attr' => array('class' => 'select2 input-large form-control'),
                    'required' => false,
                    'empty_value' => 'Seleccione...'))
                ->add('gerenciaSecond', 'entity', array(
                    'class' => 'Pequiven\MasterBundle\Entity\GerenciaSecond',
                    'property' => 'description',
                    'required' => false,
                    'empty_data' => null,
                    'empty_value' => 'Ninguna',
                    'required' => false,
                    'label' => 'Gerencia de 2da Línea',
                    'attr' => array('class' => 'select2 input-xlarge')))
                ->add('direction', null, array(
                    'label' => 'pequiven_seip.direction',
                    'translation_domain' => 'PequivenSEIPBundle',
                    'attr' => array('class' => 'select2 input-xlarge')))
                ->add('plantReports', 'entity', array(
                    'class' => 'Pequiven\SEIPBundle\Entity\DataLoad\PlantReport',
                    'property' => 'plant',
                    'required' => false,
                    'empty_data' => null,
                    'label' => 'Reportes de Plantas de Producción',
                    'attr' => array('class' => 'select2 input-xlarge'),
                    'multiple' => true,
                    'group_by' => 'reportTemplate'))
                ->add('reportTemplates', 'entity', array(
                    'class' => 'Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate',
                    'property' => 'name',
                    'required' => false,
                    'empty_data' => null,
                    'empty_value' => 'Ninguna',
                    'label' => 'Report Templates de Producción',
                    'attr' => array('class' => 'select2 input-xlarge'),
                    'multiple' => true))
                ->add('groups', 'entity', $parametersUser)
                ->add('roles', 'choice', array(
                    'label' => 'pequiven_seip.group_roles',
                    'translation_domain' => 'PequivenSEIPBundle',
                    'choices' => array(
                        'ROLE_WORKER_PQV' => 'Trabajador de pequiven',
                        'ROLE_WORKER_PLANNING' => 'Trabajador de planificacion'),
                    'multiple' => true,
                    'required' => false,
                    'attr' => array('class' => 'select2 input-xlarge')))
        /* ->add('plantReports', null, array(
          'query_builder' => function(\Pequiven\SEIPBundle\Repository\DataLoad\PlantReportRepository $repository) {
          return $repository->findByPlantReport();
          },
          'label' => 'Reportes de plantas',
          'label_attr' => array('class' => 'label'),
          'attr' => array(
          'class' => "input-xlarge select2",
          //'style' => 'width: 270px',
          //'multiple' => 'multiple'
          ),
          'multiple' => true,
          'group_by' => 'reportTemplate',
          'required' => true,
          )) */
//            ->add('supervised',null,array(
//                'label' => 'pequiven_seip.supervised',
//                'translation_domain' => 'PequivenSEIPBundle',
//                'multiple' => true,
//                'required' => false,
//                'attr' => array('class' => 'select2 input-xlarge'),
//                'query_builder' => function(\Pequiven\SEIPBundle\Repository\UserRepository $qb){
//                    return $qb->findQueryUsersByCriteria();
//                },
//            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'pequiven_seipbundle_user';
    }

}
