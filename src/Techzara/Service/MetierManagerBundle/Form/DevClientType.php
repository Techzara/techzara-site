<?php

namespace App\Techzara\Service\MetierManagerBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DevClientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cltName', TextType::class, array(
                'label'    => "Nom",
                'required' => true
            ))

            ->add('cltFirstname', TextType::class, array(
                'label'    => "Prénom",
                'required' => true
            ))

            ->add('cltAddress', TextType::class, array(
                'label'    => "Adresse",
                'required' => true
            ))

            ->add('cltTel', TextType::class, array(
                'label'    => "Téléphone",
                'required' => true
            ))

            ->add('cltMdp', PasswordType::class, array(
                'label'    => "Mot de passe",
                'required' => true
            ))

            ->add('cltIsValid', CheckboxType::class, array(
                'label'    => "Validé",
                'required' => false
            ))

            ->add('cltNomEntreprise', TextType::class, array(
                'label'    => "Entreprise",
                'required' => true
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Techzara\Service\MetierManagerBundle\Entity\DevClient'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tz_service_metiermanagerbundle_client';
    }
}
