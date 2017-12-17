<?php

/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 9/23/2017
 * Time: 5:16 PM
 */
namespace AppBundle\Form\Type;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('title', TextType::class);

//        $builder->add('author', TextType::class);

        $builder->add('release_year', DateType::class);

        $builder->add(  'publisher', TextType::class);

        $builder->add(  'genre', TextType::class);

        $builder->add(  'language', TextType::class);

        $builder->add('pages_number', NumberType::class);

        $builder->add('description', TextareaType::class);

//        $builder->add('name', null, array(
//            'required'   => false,
//            'empty_data' => 'John Doe',
//        ));

//        $user = $this->em->getRepository('AppBundle:User')->find('userId');
//        $user->getEmail();

//        $builder
//            ->add('user', ChoiceType::class, array(
//                'choices' => array('Email' => $user)));
//        $builder->add('user', TextType::class);

//        $user2 =
//        $user = $this->em->getRepository('AppBundle:User')->
        //$user = $this->get('se')

//        $builder->add('user', EntityType::class, [
//            'class' => 'AppBundle\Entity\User',
//            'attr' => [
//                'user' => 'labas',
//            ],
//        'placeholder' => '',
//        ]);

//        $builder->add('upload_book', FileType::class, array('label' => 'Book (PDF file)'));

//        $builder->add('comments_count', NumberType::class);
//
//        $builder->add('rating', NumberType::class);
//
//        $builder->add('readers_count', NumberType::class);
//
//        $builder->add('last_read_page', NumberType::class);

//        $builder->add('save', SubmitType::class);

        //$builder->add('genre', TextType::class);

        //$builder->add('book_type', NumberType::class);
    }

    public function getName()
    {
        return 'book';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Book',
            'translation_domain' => 'fields',
        ]);
    }
}