<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Entity\Tasklist;

class TasklistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
            ->add('name', TextType::class, [
                'label' => 'entity.Task.name'
            ])
            ->add('is_default', CheckboxType::class, [
                'label' => 'entity.Task.is_default',
                'required' => false
            ])
            ->add('users', EntityType::class, array(
                'label' => 'entity.Task.users_selection',
                'class' => User::class,
                'query_builder' => function (UserRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.is_active = 1')
                        ->andWhere('u.is_buyer = 1')
                        ->orderBy('u.username', 'ASC');
                },
                'choice_label' => function ($choiceValue, $key, $value) {
                        return $choiceValue->getFirstName() . ' ' . $choiceValue->getLastName();
                    },
                'choice_translation_domain' => false,
                'multiple' => true,
                'expanded' => true,
                'required' => false
            ));

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Tasklist::class,
        ));
    }

}