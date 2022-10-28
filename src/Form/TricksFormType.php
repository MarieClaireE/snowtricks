<?php
namespace App\Form;


use App\Entity\Figures;
use App\Entity\Images;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;


class TricksFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('name', TextType::class)
			->add('description', TextareaType::class)
			->add('photoPresentation', FileType::class,[
				'label' => false,
				'multiple' => false,
				'mapped' => false,
				'required' => false,
				'attr' => [
					'accept' => 'image/jpeg, image/png'
				]
			])
			->add('photos', FileType::class,[
				'label' => false,
				'multiple' => true,
				'mapped' => false,
				'required' => false,
				'attr' => [
					'accept' => 'image/jpeg, image/png'
				]
			])

			->add('videos', FileType::class,[
				'label' => false,
				'multiple' => true,
				'mapped' => false,
				'required' => false,
				'attr' => [
					'accept' => 'video/*'
				]
			])
			->add('groupe', ChoiceType::class, [
				'choices' => [
					'Grabs' => 1,
					'Rotations' => 2,
					'Flips' => 3,
					'Rotation désaxée' => 4,
					'Slides' => 5,
					'One foot tricks' => 6,
					'Old school' => 7
				]
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
				'data_class' => Figures::class
		]);
	}
}