<?php


namespace App\Form\Type;


use App\Entity\Sport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SportType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name',null)
                ->add('description',null)
                ->add('thumbnailImage', null)
                ->add('thumbnailGreenImage', null)
                ->add('thumbnailImageData', null)
                ->add('thumbnailImageGreenData', null)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sport::class,
        ]);
    }
}