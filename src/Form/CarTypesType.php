<?php

use App\Entity\TariffTypes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class TariffType extends AbstractType{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder->add('name',TextType::class,[
            'required' =>true,
            'constraints'=>[
                new NotBlank(),
            ]
        ])
            ->add('description',TextType::class,[
                'required' =>true,
                'constraints'=>[
                    new NotBlank(),
                ]
            ])
            ->add('price',NumberType::class,[
                'required' =>true,
                'constraints'=>[
                    new NotBlank(),
                ]
            ])


            ->add('save',SubmitType::class,array('label'=>'Add Tariff'));
    }
    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => \App\Entity\Tariff::class
        ]);
    }
}