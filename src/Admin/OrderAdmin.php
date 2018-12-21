<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 20/11/18
 * Time: 1:01 AM
 */

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class OrderAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('id', IntegerType::class)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
//            ->add('price', IntegerType::class)
            ->add('phone', TextType::class)
            ->add('email', EmailType::class)
            ->add('createdAt', DateTimeType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id')
            ->add('firstName')
            ->add('lastName')
//            ->add('price')
            ->add('phone')
            ->add('email')
            ->add('createdAt');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')
            ->add('firstName')
            ->add('lastName')
//            ->add('price')
            ->add('phone')
            ->add('email')
            ->add('createdAt');
    }
}