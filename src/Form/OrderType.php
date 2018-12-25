<?php

namespace App\Form;

use App\Entity\Orders;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, array(
        'required'   => true, 'label' => 'First Name'))
            ->add('lastName',TextType::class, array(
        'required'   => true, 'label' => 'Last Name'))
            ->add('phone', TextType::class, array(
                'required'   => false, 'label' => 'Contact Phone'))
            ->add('email',EmailType::class, array(
        'required'   => true, 'label' => 'Email'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Orders::class,
        ]);
    }
}
