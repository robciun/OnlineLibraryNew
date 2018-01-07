<?php
/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 1/7/2018
 * Time: 11:32 AM
 */

namespace AppBundle\Form\Type;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{

    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('oldPassword', PasswordType::class);
        $builder->add('newPassword', RepeatedType::class, array(
            'type' => PasswordType::class,
            'invalid_message' => 'The password fields must match.',
            'required' => true,
            'first_options'  => array('label' => 'Password'),
            'second_options' => array('label' => 'Repeat Password'),
        ));
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => 'AppBundle\Entity\ChangePassword'
        ]);
    }

    public function getName()
    {
        return 'change_pw';
    }
}