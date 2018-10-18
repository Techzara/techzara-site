<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 10/16/18
 * Time: 11:01 PM
 */

namespace App\Techzara\Service\MetierManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TzArticle extends AbstractType
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

            ->add('author', TextType::class, array(
                'label'    => "Auteur",
                'required' => false
            ))

            ->add('content', TextareaType::class, array(
                'label'    => "Conténue de l'article",
                'required' => true
            ))

            ->add('artphoto', FileType::class, array(
                'label'    => 'Photo de l\'article',
                'mapped'   => false,
                'attr'     => array('accept' => 'image/*','type' => 'file',),
                'required' => false
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Techzara\Service\MetierManagerBundle\Entity\TzArticle'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tz_service_metiermanagerbundle_article';
    }

}