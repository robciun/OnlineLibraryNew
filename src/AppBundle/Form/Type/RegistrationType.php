<?php
/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 11/30/2017
 * Time: 3:37 PM
 */

namespace AppBundle\Form\Type;


use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
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

    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

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
                    'required' => true
//                'label' => 'Name*'
            ])
            ->add('surname', HiddenType::class)
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password*'),
                'second_options' => array('label' => 'Repeat Password*'),
            ))
        ->add('terms', CheckboxType::class, [
            'required' => true,
            'label' => 'I accept copyright',
            'data' => true,
        ]);
    }

    public function getName()
    {
        return 'user';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'validation_groups' => ['Default', 'Registration']
        ));
    }
}