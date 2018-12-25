<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 17/11/18
 * Time: 1:41 AM
 */

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategoryAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('parent')
            ->add('name')
            ->add('imageFile', FileType::class)
            ->add('imageName')
            ->add('imageSize');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('parent')
            ->add('name')
//            ->add('imageFile')//, FileType::class)
            ->add('imageName')
            ->add('imageSize');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('parent')
            ->add('name')
            ->add('imageFile')//, FileType::class)
            ->add('imageName')
            ->add('imageSize');
    }
}     