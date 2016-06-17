<?php

namespace Pequiven\SEIPBundle\Form\Politic;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MeetingFileType extends AbstractType {

    /**
     * @author Victor Tortolero
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('nameFile', 'file', array(
                    'label' => 'Archivo',
                    'label_attr' => array('class' => 'label'),
                    'required' => true,
                    'mapped' => false,
                    'attr' => array('class' => 'input input-xlarge')))
                
                ->add('meeting', 'entity', array(
                    'label' => 'Categorias',
                    'label_attr' => array('class' => 'label'),
                    'class' => 'Pequiven\SEIPBundle\Entity\Politic\CategoryFile',
                    'property' => 'description',
                    'empty_value' => 'Seleccione',
                    'required' => true,
                    'multiple' => true,
                    'attr' => array(
                        'class' => 'select2 input-large form-control',)))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\Politic\MeetingFile'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'meetingFile_data';
    }

}
