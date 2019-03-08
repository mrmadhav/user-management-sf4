<?php
/**
 * Created by PhpStorm.
 * User: madhav
 * Date: 2019-03-07
 * Time: 21:27
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('username')
            ->add('email')
            ->add('plain_password')
            ->add('roles', ChoiceType::class, [
                    'choices' => [
                        'USER' => 'ROLE_USER',
                        'ADMIN' => 'ROLE_ADMIN'
                    ],
                    'multiple' => true
                ])
            ->add('user_groups')
            ->add('save', SubmitType::class, ['label' => 'Save changes'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}