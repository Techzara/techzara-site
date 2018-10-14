<?php

namespace App\Techzara\Service\MetierManagerBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DevPortfolioType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pfTitle', TextType::class, array(
                'label'    => "Première titre",
                'required' => true
            ))

            ->add('pfUrl', UrlType::class, array(
                'label'    => "Url",
                'required' => false
            ))

            ->add('pfDescription', TextareaType::class, array(
                'label'    => "Description",
                'required' => false
            ))

            ->add('pfImageUrl', FileType::class, array(
                'label'    => 'Image',
                'mapped'   => false,
                'attr'     => array('accept' => 'image/*'),
                'required' => false
            ))

            ->add('lvPortfolioType', EntityType::class, array(
                'label'         => 'Type',
                'class'         => 'App\Techzara\Service\MetierManagerBundle\Entity\DevPortfolioType',
                'query_builder' => function (EntityRepository $_er) {
                    return $_er
                        ->createQueryBuilder('pf_tp')
                        ->orderBy('pf_tp.pfTpLabel', 'ASC');
                },
                'choice_label'  => 'pfTpLabel',
                'multiple'      => false,
                'expanded'      => false,
                'required'      => true,
                'placeholder'   => '- Séléctionner Catégorie -'
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Techzara\Service\MetierManagerBundle\Entity\DevPortfolio'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tz_service_metiermanagerbundle_portfolio_type';
    }
}
