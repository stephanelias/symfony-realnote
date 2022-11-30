<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('release_date',DateType::class,[
                'widget' => 'choice',
                'years' => range(date('Y')-50,date('Y')+20)
            ])
            ->add('artists',EntityType::class, [
                'by_reference' =>  false,
                'class'=> Artist::class ,
                'choice_label' => 'name',
                'multiple'=> true ,
                'expanded' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
            ])
            ->add('category',EntityType::class,[
                'by_reference' =>  true,
                'class'=> Category::class ,
                'choice_label' => 'name',
                'multiple'=> false,
                'expanded' => true,
            ])
            ->add('titles',CollectionType::class,[
                'entry_type' => TitleType::class ,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true ,
                'error_bubbling'=> false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
