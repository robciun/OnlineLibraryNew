<?php

/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 9/23/2017
 * Time: 5:16 PM
 */
namespace AppBundle\Form\Type;

use AppBundle\Entity\User;
use blackknight467\StarRatingBundle\Form\RatingType;
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

        $builder->add('title', TextType::class, [
            'required' => true,
            'label' => 'Title*'
        ]);

        $builder->add('release_year', DateType::class, [
            'years' => range(date('Y') - 100, date('Y') + 1),
        ]);

        $builder->add(  'publisher', TextType::class, [
            'required' => false,
        ]);

        $builder->add(  'genre', TextType::class, [
            'required' => true,
            'label' => 'Genre*'
        ]);

        $builder->add(  'language', TextType::class, [
            'required' => true,
            'label' => 'Language*'
        ]);

        $builder->add('pages_number', NumberType::class, [
            'required' => true,
            'label' => 'Pages number*'
        ]);

        $builder->add('description', TextareaType::class, [
            'required' => true,
            'label' => 'Description*'
        ]);

        $builder->add('isbn', TextType::class, [
            'required' => false
        ]);

    }

    public function getName()
    {
        return 'book';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Book',
        ]);
    }
}