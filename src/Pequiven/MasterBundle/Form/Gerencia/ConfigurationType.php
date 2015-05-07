<?php

namespace Pequiven\MasterBundle\Form\Gerencia;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConfigurationType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $parametersUser = array(
            'class' => 'Pequiven\SEIPBundle\Entity\User',
            'property' => 'fullNameUser',
            'attr' => array(
                'class' => 'select2 input-xlarge'
            ),
            'query_builder' => function(\Pequiven\SEIPBundle\Repository\UserRepository $qb){
                return $qb->findQueryUsersByCriteria();
            },
            'multiple' => true,
        );
        $builder
            ->add('arrangementProgramUserToRevisers','entity',$parametersUser)
            ->add('arrangementProgramUsersToApproveTactical','entity',$parametersUser)
            ->add('arrangementProgramUsersToApproveOperative','entity',$parametersUser)
            ->add('arrangementProgramUsersToNotify','entity',$parametersUser)
            ->add('arrangementProgramSigUsersToReviser','entity',$parametersUser)
            ->add('arrangementProgramSigUsersToApprove','entity',$parametersUser)
            ->add('arrangementProgramSigUsersToNotify','entity',$parametersUser)
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\MasterBundle\Entity\Gerencia\Configuration'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_masterbundle_gerencia_configuration';
    }
}
