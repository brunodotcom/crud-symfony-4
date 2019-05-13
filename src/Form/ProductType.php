<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Product Name",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('price', TextType::class, [
                "label" => "Product Price ",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('description', TextareaType::class, [
                "label" => "Product Description",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('submit', SubmitType::class, [
                "label" => "Save",
                "attr" => [
                     "class" => "btn btn-primary"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
