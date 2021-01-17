<?php

use App\Entity\Tariff;
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

class OrdersType extends AbstractType{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder->add('location',TextType::class,[
            'required' =>true,
            'constraints'=>[
                new NotBlank(),
            ]
        ])
            ->add('tariff_id',EntityType::class,[
                'class' =>\App\Entity\Tariff::class,
                'label' =>' tariff',
                'choice_label' =>'name'
            ])
            ->add('dateFrom',DateType::class,[
                'required' =>true,
                'constraints'=>[
                    new NotBlank(),
                ],
                'attr' =>['type'=> 'date','id'=>'date','name'=>'dateFrom']


            ])
            ->add('time_from',TimeType::class,[
                'required' =>true,
                'constraints'=>[
                    new NotBlank(),
                ],
                'attr' =>['data-role'=> 'timepicker','name'=>'time','data-seconds'=>'false','data-locale'=>'uk-UA']


            ])
            ->add('time_to',TimeType::class,[
                'required' =>true,
                'constraints'=>[
                    new NotBlank(),
                ],
                'attr' =>['data-role'=> 'timepicker','name'=>'time','data-seconds'=>'false','data-locale'=>'uk-UA']


            ])

            ->add('save',SubmitType::class,array('label'=>'Order car'));
    }
    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => \App\Entity\Orders::class
        ]);
    }
}