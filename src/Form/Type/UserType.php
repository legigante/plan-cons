<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
            ->add('username', EmailType::class, [
                'label' => 'login.username'
            ])
            ->add('first_name', TextType::class, [
                'label' => 'entity.User.first_name'
            ])
            ->add('last_name', TextType::class, [
                'label' => 'entity.User.last_name'
            ])
            ->add('is_buyer', CheckboxType::class, [
                'label' => 'entity.User.is_buyer',
                'required'=>false
            ]);

    }

}