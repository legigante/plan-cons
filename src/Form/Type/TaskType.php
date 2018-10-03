<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use App\Entity\Task;
use App\Entity\Tasklist;
use App\Repository\UserRepository;
use App\Entity\User;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
            ->add('tasklist', EntityType::class, [
                'label' => 'entity.Task.label',
                'class' => Tasklist::class,
                'choice_label' => 'name',
                'choice_translation_domain' => false
            ])
            ->add('users', EntityType::class, array(
                'label' => 'entity.Task.users',
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
                'expanded' => true
            ))
            ->add('budget', IntegerType::class, [
                'label' => 'entity.Task.budget',
                'required' => false
            ])
            ->add('date_rla', DateType::class, [
                'label' => 'entity.Task.date_rla'
            ])
            ->add('date_start', DateType::class, [
                'label' => 'entity.Task.date_start'
            ])
            ->add('date_expected_end', DateType::class, [
                'label' => 'entity.Task.date_expected_end'
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'entity.Task.comment',
                'required' => false
            ])
            ->add('is_prio', CheckboxType::class, [
                'label' => 'entity.Task.is_prio'
            ])
            ->add('comment2', TextareaType::class, [
                'label' => 'entity.Task.comment2',
                'required' => false
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Task::class,
        ));
    }

}