<?php


use App\Entity\CarTypes;
use Symfony\Component\Form\AbstractType;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;

class FilterCarsType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->setMethod('GET');
        $builder
            ->add('name',Filters\TextFilterType::class)
            ->add('model',Filters\TextFilterType::class)
            ->add('color',Filters\TextFilterType::class)
            ->add('year',Filters\NumberFilterType::class)
            ->add('type_id',Filters\EntityFilterType::class,[
                'data_class' => CarTypes::class,
                'class' => CarTypes::class,
                'choice_label' =>'type_name',
            ])
            ->add('location',Filters\TextFilterType::class)
            ->add('find',SubmitType::class,[
                'label' => 'find',
                'attr' =>['name' => 'submit_filter','value' => 'filter']
            ]);

    }

    public function getBlockPrefix()
    {
        return 'item_filter';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}