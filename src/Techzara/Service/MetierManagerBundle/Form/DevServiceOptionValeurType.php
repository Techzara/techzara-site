<?php

namespace App\Techzara\Service\MetierManagerBundle\Form;

use App\Techzara\Service\MetierManagerBundle\Utils\ValeurTypeName;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevServiceOptionValeurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('srvOptValTpVal', ChoiceType::class, array(
                'label'       => 'Type valeur',
                'placeholder' => false,
                'required'    => true,
                'choices'     => ValeurTypeName::$TYPE_VALEUR,
                'expanded'    => true
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Techzara\Service\MetierManagerBundle\Entity\DevServiceOptionValeurType'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tz_service_metiermanagerbundle_service_option_valeur_type';
    }
}
