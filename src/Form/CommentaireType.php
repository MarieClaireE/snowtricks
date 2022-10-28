<?php

namespace App\Form;

use App\Entity\Commentaires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('commentaire', TextareaType::class, [
							'label' => 'Votre commentaire',
	            'attr' => [
								'class' => 'form-control'
	            ]
            ])
            ->add('rgpd', CheckboxType::class, [
							'attr' => [
								'class' => 'me-1 ms-1'
							]
            ])
            ->add('parentId', HiddenType::class, [
							'mapped' => false
            ])
	          ->add('envoyer', SubmitType::class, [
							'attr' =>[
								'class'=> 'form-control bg-secondary text-white'
							]
	          ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaires::class,
        ]);
    }
}
