<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 17/11/18
 * Time: 1:24 AM
 */

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('category')
            ->add('model')
            ->add('manufacturer')
            ->add('price')
            ->add('date_added');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('category')
            ->add('model')
            ->add('manufacturer')
            ->add('price')
            ->add('date_added');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')
            ->add('category')
            ->add('model')
            ->add('manufacturer')
            ->add('price')
            ->add('date_added');
    }
}