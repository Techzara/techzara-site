<?php

namespace App\Techzara\Service\MetierManagerBundle\Form;

use App\Techzara\Service\MetierManagerBundle\Utils\EtatFactureName;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DevFactureType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fctStatus', ChoiceType::class, array(
                'label'       => 'Statut',
                'placeholder' => false,
                'required'    => true,
                'choices'     => EtatFactureName::$TYPE_VALEUR,
                'expanded'    => true
            ))

            ->add('lvServiceClient', EntityType::class, array(
                'label'         => 'Service client',
                'class'         => 'App\Techzara\Service\MetierManagerBundle\Entity\DevServiceClient',
                'query_builder' => function (EntityRepository $_er) {
                    return $_er
                        ->createQueryBuilder('srv_clt')
                        ->orderBy('srv_clt.srvCltDate', 'DESC');
                },
                'choice_label'  => 'serviceValidationString',
                'multiple'      => false,
                'expanded'      => false,
                'required'      => true,
                'placeholder'   => '- Séléctionner Service client -'
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Techzara\Service\MetierManagerBundle\Entity\DevFacture'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tz_service_metiermanagerbundle_facture';
    }
}
