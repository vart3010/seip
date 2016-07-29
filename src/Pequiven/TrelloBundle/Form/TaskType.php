<?php

namespace Pequiven\TrelloBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TaskType extends AbstractType
{

    protected $user;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Título'))
            ->add('description', TextareaType::class, array('label' => 'Descripción'))
            ->add('categoryTrello', TextareaType::class, array('label' => 'Categoría'))
            ->add('save', SubmitType::class, array('label' => 'Generar'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\TrelloBundle\Entity\TaskTrello'
        ));
    }

    public function getName()
    {
        return 'actionTrelloTask';
    }
}