<?php

namespace App\Techzara\Service\MetierManagerBundle\Form;

use Koff\Bundle\I18nFormBundle\Form\Type\TranslationsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DevFaqType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('translations', TranslationsType::class, [
                'label'  => false,
                'fields' => [
                    'faqtQuestion' => [
                        'field_type' => TextareaType::class,
                        'label'      => 'question.',
                        'locale_options' => [
                            'en' => ['label' => 'Question'],
                            'fr' => ['label' => 'Question']
                        ]
                    ],
                    'faqttResponse' => [
                        'field_type' => TextareaType::class,
                        'label'      => 'content.',
                        'locale_options' => [
                            'en' => ['label' => 'Answer'],
                            'fr' => ['label' => 'Réponse']
                        ]
                    ]
                ],
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Techzara\Service\MetierManagerBundle\Entity\DevFaq'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tz_service_metiermanagerbundle_faq';
    }
}
