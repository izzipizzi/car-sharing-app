<?php


use App\Entity\Cars;
use App\Entity\CarTypes;
use App\Entity\Tariff;
use Symfony\Component\Form\AbstractType;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;

class FilterAdminOrdersType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->setMethod('GET');
        $builder
            ->add('id',Filters\TextFilterType::class,[
                'label'=>'Номер замовлення',

            ])
            ->add('client_id',Filters\TextFilterType::class,[
                'label'=>'Номер клієнта',

            ])
            ->add('dateFrom',Filters\DateRangeFilterType::class,[
                'label'=>'Дата',
                'left_date_options' => [
                    'label' => 'З',
                    'attr' =>['type'=> 'date','id'=>'date']
                ],
                'right_date_options' => [
                    'label' => 'По',
                    'attr' =>['type'=> 'date','id'=>'date']
                ]

            ])
            ->add('time_from',Filters\DateTimeFilterType::class,[
                'label'=>'Час з',

            ])
            ->add('time_to',Filters\DateTimeFilterType::class,[
                'label'=>'Час до',

            ])
            ->add('year',Filters\NumberFilterType::class,[
                'label'=>'Рік',

            ])
            ->add('car_id',Filters\EntityFilterType::class,[
                'data_class' => Cars::class,
                'label'=>'Марка машини',
                'class' => Cars::class,
                'choice_label' =>'name',
            ])
            ->add('tariff_id',Filters\EntityFilterType::class,[
                'data_class' => Tariff::class,
                'label'=>'Назва тарифу',

                'class' => Tariff::class,
                'choice_label' =>'name',
            ])
            ->add('location',Filters\TextFilterType::class,[
                'label'=>'Розташування',

            ])
            ->add('price',Filters\TextFilterType::class,[
                'label'=>'Ціна',

            ])
            ->add('find',SubmitType::class,[
                'label' => 'Знайти',
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