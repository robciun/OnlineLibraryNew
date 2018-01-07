<?php
/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 1/6/2018
 * Time: 7:30 PM
 */

namespace AppBundle\Form\Type;



use AppBundle\Entity\Search;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    protected $perPage = 10;
    protected $perPageChoices = array(2,5,10);

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $perPageChoices = array();
        foreach($this->perPageChoices as $choice){
            $perPageChoices[$choice] = 'Display '.$choice.' items';
        }

        $builder
            ->add('sort', 'hidden', array(
                'required' => false,
            ))
            ->add('direction', 'hidden', array(
                'required' => false,
            ))
            ->add('sortSelect','choice',array(
                'choices' => Search::$sortChoices,
            ))
            ->add('perPage', 'choice', array(
                'choices' => $perPageChoices,
            ))
            ->add('search','submit',array(
                'attr' => array(
                    'class' => 'btn btn-primary',
                )
            ))
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                // emulate sortSelect submission to prefill the field
                $articleSearch = $event->getData();

                if(array_key_exists('sort',$articleSearch) && array_key_exists('direction',$articleSearch)){
                    $articleSearch['sortSelect'] = $articleSearch['sort'].' '.$articleSearch['direction'];
                }else{
                    $articleSearch['sortSelect'] = '';
                }

                $event->setData($articleSearch);
            })
            ->add('title',TextType::class,array(
                'required' => false,
            ))
            ->add('author',TextType::class,array(
                'required' => false,
            ))
            ->add('release_year',DateType::class,array(
                'required' => false,
            ))
            ->add('publisher',TextType::class,array(
                'required' => false,
            ))
            ->add('genre',TextType::class,array(
                'required' => false,
            ))
            ->add('language',TextType::class,array(
                'required' => false,
            ))
            ->add('pages_number',NumberType::class,array(
                'required' => false,
            ))
            ->add('description',TextType::class,array(
                'required' => false,
            ))
            ->add('rating',NumberType::class,array(
                'required' => false,
            ))
            ->add('date_created',DateTimeType::class,array(
                'required' => false,
            ))
            ->add('book_name',TextType::class,array(
                'required' => false,
            ))
            ->add('ISBN',TextType::class,array(
                'required' => false,
            ))
            ->add('search','submit')
        ;
    }

    public function getName()
    {
        return 'search';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Book'
        ]);
    }
}