<?php

namespace App\Form;

use App\Dto\Request\LinkCreateRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class LinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url', UrlType::class, [
                'label' => 'Оригінальний URL',
                'required' => true,
                 'row_attr' => [
                    'class' => 'col-auto',
                ],
                'attr' => [
                    'placeholder' => 'Введіть URL',
                    'class' => 'form-control',
                    'style' => 'width:300px;',
                ],
            ])
            ->add('timeToLive', IntegerType::class, [
                'label' => 'Час існування (години)',
                'required' => true,
                'row_attr' => [
                    'class' => 'col-auto',
                ],
                'attr' => [
                    'min' => 1,
                    'step' => 1,
                    'class' => 'form-control',
                    'style' => 'width:170px;',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Скоротити url',
                'row_attr' => [
                    'class' => 'col-12 d-flex justify-content-center mt-5',
                ],
                'attr' => [
                    'class' => 'btn btn-success px-4',
                ],    
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LinkCreateRequest::class,
        ]);
    }
}
