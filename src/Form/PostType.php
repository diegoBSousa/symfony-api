<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Url;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'constraints' => [
                        new NotNull([
                            'message' => 'Title cannot be empty!'
                        ]),
                    ]
                ]
            )
            ->add(
                'content',
                TextType::class,
                [
                    'constraints' => [
                        new NotNull([
                            'message' => 'Content cannot be empty!'
                        ]),
                    ]
                ]
            )
            ->add(
                'image',
                UrlType::class,
                [
                    'constraints' => [
                        new NotNull([
                            'message' => 'Image cannot be empty!'
                        ]),
                        new Url()
                    ]
                ]
            )
            ->add('tags');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
