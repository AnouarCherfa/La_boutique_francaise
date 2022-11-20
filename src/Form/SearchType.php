<?php

namespace App\Form;

use App\Classe\Search;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('string', TextType::class, [
                'label'     => 'Rechercher',
                'required'  => false,
                'attr'      => [
                    'placeholder'   => 'Votre recherche ...',
                    'Class'         => 'form-control-sm'
                ]
            ])
            ## liéer l'input a la classe Category
            ->add('categories', EntityType::class, [
                'label'     => false,
                'required'  => false,
                'class'     => Category::class,
                'multiple'  => true,
                'expanded'  => true

            ])
            ->add('submit', SubmitType::class, [
                'label'     => 'Filtrer',
                'attr'      => [
                    'class' => 'btn-block btn-info'
                ]
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'        => Search::class,
            'method'            => 'Get',
            'CRSF_protection'   => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}