<?php
namespace App\Form;


use App\Entity\Figures;
use App\Entity\Images;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
			->add('images', FileType::class, [
				'label' => false,
				'multiple' => false,
				'mapped' => false,
				'required' => false
			])
			->add('images2', FileType::class, [
				'label' => false,
				'multiple' => false,
				'mapped' => false,
				'required' => false
			])
			->add('images3', FileType::class, [
				'label' => false,
				'multiple' => false,
				'mapped' => false,
				'required' => false,
			])

			->add('videos', FileType::class, [
				'label' => false,
				'multiple' => false,
				'mapped' => false,
				'required' => false
			])
			->add('videos2', FileType::class, [
				'label' => false,
				'multiple' => false,
				'mapped' => false,
				'required' => false
			])
			->add('videos3', FileType::class, [
				'label' => false,
				'multiple' => false,
				'mapped' => false,
				'required' => false
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