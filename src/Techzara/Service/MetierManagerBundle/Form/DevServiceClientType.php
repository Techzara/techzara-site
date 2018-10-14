<?php

namespace App\Techzara\Service\MetierManagerBundle\Form;

use App\Techzara\Service\MetierManagerBundle\Utils\RoleName;
use App\Techzara\Service\MetierManagerBundle\Utils\ValeurTypeName;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DevServiceClientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->type_action = $options['type_action'];

        $builder
            ->add('srvCltPrix', TextType::class, array(
                'label'    => "Total prix (en €)",
                'attr'     => array(
                    'pattern'  => "[0-9]+([,\.][0-9]+)?",
                    'readonly' => true
                ),
                'required' => false
            ))

            ->add('srvCltNbrPage', TextType::class, array(
                'label'    => "Nombre de page à intégrer",
                'attr'     => array('pattern' => "[0-9]+([,\.][0-9]+)?"),
                'required' => true
            ))

            ->add('srvCltNbrPageDecline', TextType::class, array(
                'label'    => "Nombre de pages déclinées",
                'attr'     => array('pattern' => "[0-9]+([,\.][0-9]+)?"),
                'required' => false
            ))

            ->add('srvCltProjectLink', UrlType::class, array(
                'label'    => "Lien projet",
                'required' => false
            ))

            ->add('srvCltDateLivraison', DateTimeType::class, array(
                'label'    => "Date livraison",
                'widget'   => 'single_text',
                'format'   => 'dd/MM/yyyy HH:mm',
                'attr'     => array('class' => $this->type_action == 'create' ? 'datetimepicker-min-now' : 'datetimepicker'),
                'required' => false
            ))

            ->add('srvCltDesc', TextareaType::class, array(
                'label'    => "Description projet",
                'required' => false
            ))

            ->add('lvUser', EntityType::class, array(
                'label'         => 'Client',
                'class'         => 'App\Techzara\Service\UserBundle\Entity\User',
                'query_builder' => function (EntityRepository $_er) {
                    return $_er
                        ->createQueryBuilder('usr')
                        ->where('usr.tzRole = :id_role')
                        ->setParameter('id_role', RoleName::ID_ROLE_CLIENT)
                        ->groupBy('usr.usrNomEntreprise')
                        ->orderBy('usr.email', 'ASC');
                },
                'choice_label'  => 'usrEntreprise',
                'multiple'      => false,
                'expanded'      => false,
                'required'      => true,
                'placeholder'   => '- Séléctionner Client -'
            ))

            ->add('lvService', EntityType::class, array(
                'label'         => 'Service',
                'class'         => 'App\Techzara\Service\MetierManagerBundle\Entity\DevService',
                'query_builder' => function (EntityRepository $_er) {
                    return $_er
                        ->createQueryBuilder('srv')
                        ->orderBy('srv.srvLabel', 'ASC');
                },
                'choice_label'  => 'srvLabelString',
                'multiple'      => false,
                'expanded'      => false,
                'required'      => true,
                'placeholder'   => '- Séléctionner Service -'
            ))

            ->add('lvServiceOptions', EntityType::class, array(
                'label'         => 'Option(s) service',
                'class'         => 'App\Techzara\Service\MetierManagerBundle\Entity\DevServiceOption',
                'query_builder' => function (EntityRepository $_er) {
                    return $_er
                        ->createQueryBuilder('so')
                        ->leftJoin('so.lvServiceOptionValeurType', 'so_val_tp')
                        ->where('so_val_tp.srvOptValTpVal <> :val')
                        ->setParameter('val', ValeurTypeName::ID_GRATUIT)
                        ->orderBy('so.lvServiceOptionType', 'ASC');
                },
                'choice_label'  => 'srvOptLabel',
                'multiple'      => true,
                'required'      => false
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Techzara\Service\MetierManagerBundle\Entity\DevServiceClient',
            'type_action' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tz_service_metiermanagerbundle_service_client';
    }
}
