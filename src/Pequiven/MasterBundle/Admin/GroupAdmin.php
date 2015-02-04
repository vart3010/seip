<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\UserBundle\Admin\Entity\GroupAdmin as BaseGroupAdmin;

/**
 * Description of GroupAdmin
 *
 * @author Carlos Mendoza <inhack20@tecnocreaciones.com>
 */
class GroupAdmin extends BaseGroupAdmin
{
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
        $show
            ->add('name')
            ;
    }
    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('roles')
        ;
    }
}
