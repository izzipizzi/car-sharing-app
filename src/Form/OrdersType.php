<?php

use App\Entity\CarTypes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class CarsType extends AbstractType{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder->add('name',TextType::class,[
            'required' =>true,
            'constraints'=>[
                new NotBlank(),
            ]
        ])
            ->add('type',EntityType::class,[
                'class' =>CarTypes::class,
                'choice_label' =>'type_name'
            ])
            ->add('model',TextType::class)
            ->add('color',TextType::class)
            ->add('year',NumberType::class)
            ->add('photo',FileType::class,[
                'mapped'=>false,
                'required'=>true,
                'constraints'=>[
                    new File([
                        'maxSize'=>'10000k',
                        'mimeTypes'=>[
                            'image/jpeg',
                            'image/png'
                        ],
                        'mimeTypesMessage'=>'Upload image file'
                    ])
                ]
            ])
            ->add('save',SubmitType::class,array('label'=>'Add car'));
    }
    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => \App\Entity\Cars::class
        ]);
    }
}