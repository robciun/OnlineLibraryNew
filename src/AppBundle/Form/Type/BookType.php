<?php

/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 9/23/2017
 * Time: 5:16 PM
 */
namespace AppBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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

        $builder->add('author', TextType::class);

        $builder->add('release_year', DateType::class);

        $builder->add(  'language', TextType::class);

        $builder->add('pages_number', NumberType::class);

        $builder->add('description', TextType::class);

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