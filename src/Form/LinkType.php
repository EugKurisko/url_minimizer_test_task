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
                'row_attr' => ['class' => 'mb-3'],
                'required' => true,
                'attr' => [
                    'placeholder' => 'Введіть URL', 'class' => 'form-control',
                    'style' => 'max-width:700px;',
                ],
            ])
            ->add('timeToLive', IntegerType::class, [
                'label' => 'Час життя (години)',
                'required' => true,
                'attr' => [
                    'min' => 1,
                    'step' => 1,
                    'class' => 'form-control'
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Скоротити url',
                'attr' => [
                    'class' => 'btn btn-success mt-3 w-100'
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
