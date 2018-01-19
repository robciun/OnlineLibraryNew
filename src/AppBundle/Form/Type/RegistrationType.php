<?php
/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 11/30/2017
 * Time: 3:37 PM
 */

namespace AppBundle\Form\Type;


use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
//                'label' => 'Email*'
            ])
            ->add('username', TextType::class, [
//                'label' => 'Username*'
            ])
            ->add('name', TextType::class, [
//                'label' => 'Name*'
            ])
            ->add('surname', HiddenType::class)
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password*'),
                'second_options' => array('label' => 'Repeat Password*'),
            ))
        ->add('terms', CheckboxType::class, [
            'label' => 'I accept copyright'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'validation_groups' => ['Default', 'Registration']
        ));
    }
}