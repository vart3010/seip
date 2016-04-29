<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\ObjetiveBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

/**
 * Formulario de objetivo
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ObjetiveFormType extends AbstractType 
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options) 
    {
        $entity = new \Pequiven\ObjetiveBundle\Entity\Objetive();
        $entity = $builder->getData();
        
        $hasWeigth = false;
        if($entity->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Model\ObjetiveLevel::LEVEL_OPERATIVO){
            $hasWeigth = true;
        }
        
        $builder->add("description","textarea",array(
             'label' => 'form.objetive_statement',
             'label_attr' => array('class' => 'label'), 
             'translation_domain' => 'PequivenObjetiveBundle',
             'attr' => array('cols' => 50, 'rows' => 5,'class' => 'input small-margin-right validate[required]')
         ));
        if($hasWeigth === true){
            $builder->add("weight",null,array(
                'label' => 'form.weight',
                'label_attr' => array('class' => 'label'), 
                'translation_domain' => 'PequivenObjetiveBundle',
                'attr' => array('class' => 'input small-margin-right'),
            ));
        }
        $builder->add("goal",null,array(
            'label' => 'form.goal',
            'label_attr' => array('class' => 'label'), 
            'translation_domain' => 'PequivenObjetiveBundle',
            'attr' => array('class' => 'input small-margin-right'),
        ))
        ;
    }
    public function getName() 
    {
        return 'pequiven_objetive_form';
    }

}
