<?php

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder->add('name',TextType::class)
            ->add('surname',TextType::class)
            ->add('email',EmailType::class)
            ->add('phone', NumberType::class)
            ->add('password', RepeatedType::class, array(
                'type'              => PasswordType::class,
                'mapped'            => false,
                'first_options'     => array('label' => 'New password'),
                'second_options'    => array('label' => 'Confirm new password'),
                'invalid_message' => 'The password fields must match.',
            ))
            ->add('city',TextType::class)
            ->add('street',TextType::class)
            ->add('house',TextType::class)
            ->add('flat',TextType::class)
            ->add('save',SubmitType::class,array('label'=>'Make Account'));
    }
    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => \App\Entity\User::class
        ]);
    }
}