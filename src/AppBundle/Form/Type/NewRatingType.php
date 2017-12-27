<?php
/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 12/27/2017
 * Time: 1:55 PM
 */

namespace AppBundle\Form\Type;


use blackknight467\StarRatingBundle\Form\RatingType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewRatingType extends AbstractType
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('rating', RatingType::class);
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