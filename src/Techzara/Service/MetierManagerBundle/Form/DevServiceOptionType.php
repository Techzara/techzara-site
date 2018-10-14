<?php

namespace App\Techzara\Service\MetierManagerBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DevServiceOptionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('srvOptLabel', TextType::class, array(
                'label'    => "Libellé",
                'required' => true
            ))

            ->add('srvOptDesc', TextareaType::class, array(
                'label'    => "Description",
                'required' => false
            ))

            ->add('srvOptValeur', TextType::class, array(
                'label'    => "Valeur",
                'attr'     => array('pattern' => "[0-9]+([,\.][0-9]+)?"),
                'required' => false
            ))

            ->add('lvServiceOptionType', EntityType::class, array(
                'label'         => 'Type',
                'class'         => 'App\Techzara\Service\MetierManagerBundle\Entity\DevServiceOptionType',
                'query_builder' => function (EntityRepository $_er) {
                    return $_er
                        ->createQueryBuilder('sot')
                        ->orderBy('sot.srvOptTpLabel', 'ASC');
                },
                'choice_label'  => 'srvOptTpLabel',
                'multiple'      => false,
                'expanded'      => false,
                'required'      => true,
                'placeholder'   => '- Séléctionner Type -'
            ))

            ->add('lvServiceOptionValeurType', DevServiceOptionValeurType::class)
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Techzara\Service\MetierManagerBundle\Entity\DevServiceOption'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tz_service_metiermanagerbundle_service_option';
    }
}
