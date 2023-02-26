<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class
            , [
                'attr' => [
                    'class' => 'form-control block w-full px-3 py-1.5 text-base font-normal bg-white bg-clip border border-solid text-gray-700 focus:border-blue-600 focus-outline-none'
                ],
                'label' => 'Poster un nouveau commentaire',
                'label_attr' => [
                    'class' => 'form-label inline-block mb-2 text-gray-700'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            //  ->add('author', TextType::class)
            // ->add('createdAt')
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4 mb-5'
                ],
            'label' => 'Envoyer le commentaire'
            ]);
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
