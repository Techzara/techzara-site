<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 10/16/18
 * Time: 11:01 PM
 */

namespace App\Techzara\Service\MetierManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TzProgramme extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label'    => "Titre",
                'required' => true
            ))

            ->add('tzProgrammeDescription', TextareaType::class, array(
                'label'    => "Description",
                'required' => false
            ))

            ->add('tzProgrammeLieu', TextType::class, array(
                'label'    => "Lieu",
                'required' => false
            ))

            ->add('tzProgrammeIntervenants', TextType::class, array(
                'label'    => "Intérvenants",
                'required' => true
            ))

            ->add('tzProgrammePhoto', FileType::class, array(
                'label'    => 'Photo du programme',
                'mapped'   => false,
                'attr'     => array('accept' => 'image/*','type' => 'file',),
                'required' => false
            ))

            ->add('tzProgrammeDateDebut', DateTimeType::class, array(
                'label'  => "Date programme début",
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr'   => array(
                    'class'         => 'kl-datetimepicker--date-fin-saison datetimepicker',
                    'required'      => true,
                    'autocomplete'  => 'off'
                )

            ))

            ->add('tzProgrammeDateFin', DateTimeType::class, array(
                'label'    => "Date fin du programme",
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr'   => array(
                    'class'         => 'kl-datetimepicker--date-fin-saison datetimepicker',
                    'required'      => true,
                    'autocomplete'  => 'off'
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Techzara\Service\MetierManagerBundle\Entity\TzProgramme'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tz_service_metiermanagerbundle_programme';
    }

}