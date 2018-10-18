<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 10/17/18
 * Time: 7:17 PM
 */

namespace App\Techzara\Service\MetierManagerBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevActivite extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label'    => "Titre",
                'required' => true
            ))
            ->add('desc', TextareaType::class, array(
                'label'    => "Titre",
                'required' => true
            ));

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Techzara\Service\MetierManagerBundle\Entity\DevActivite'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tz_service_metiermanagerbundle_activite';
    }

}