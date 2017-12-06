<?php
/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 11/29/2017
 * Time: 11:30 AM
 */

namespace AppBundle\Form\Type;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteType extends AbstractType
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('note', TextType::class);
    }

    public function getName()
    {
        return 'note';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Note',
        ]);
    }
}