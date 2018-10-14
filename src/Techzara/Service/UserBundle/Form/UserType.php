<?php

namespace  App\Techzara\Service\UserBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Techzara\Service\MetierManagerBundle\Utils\RoleName;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->user_role = $options['user_role'];

        $builder
            ->add('usrLastname', TextType::class, array(
                'label'    => "Nom",
                'attr'     => array('placeholder' => 'Nom'),
                'required' => true
            ))

            ->add('usrNomEntreprise', TextType::class, array(
                'label'    => "Nom entreprise",
                'attr'     => array('placeholder' => 'Nom entreprise'),
                'required' => true
            ))

            ->add('usrFirstname', TextType::class, array(
                'label'    => "Prénom",
                'attr'     => array('placeholder' => 'Prénom'),
                'required' => true
            ))

            ->add('usrAddress', TextType::class, array(
                'label'    => "Adresse",
                'attr'     => array('placeholder' => 'Adresse'),
                'required' => false
            ))

            ->add('usrPhone', TextType::class, array(
                'label'    => "Téléphone",
                'attr'     => array('placeholder' => 'Téléphone'),
                'required' => false
            ))

            ->add('email', EmailType::class, array(
                'label'    => "Adresse email",
                'attr'     => array(
                    'pattern'     => "[^@]+@[^@]+\.[a-zA-Z]{2,}",
                    'placeholder' => 'Adresse email'
                ),
                'required' => true
            ))

            ->add('usrPhoto', FileType::class, array(
                'label'    => 'Photo de profil',
                'mapped'   => false,
                'attr'     => array('accept' => 'image/*'),
                'required' => false
            ))

            ->add('enabled', CheckboxType::class, array(
                'label'    => "Actif",
                'required' => false
            ))

            ->add('username', TextType::class, array(
                'label'    => "Nom d'utilisateur",
                'attr'     => array('placeholder' => "Nom d'utilisateur"),
                'required' => true
            ))

            ->add('tzRole', EntityType::class, array(
                'label'         => 'Rôle',
                'class'         => 'App\Techzara\Service\MetierManagerBundle\Entity\DevRole',
                'query_builder' => function (EntityRepository $_er) {
                    $_query_builder = $_er->createQueryBuilder('r');

                    if ($this->user_role == RoleName::ID_ROLE_ADMIN) {
                        $_query_builder
                            ->andWhere('r.id <> :id_role')
                            ->setParameter('id_role', RoleName::ID_ROLE_SUPERADMIN);
                    }

                    $_query_builder->orderBy('r.rlName', 'ASC');

                    return $_query_builder;
                },
                'choice_label'  => 'rlName',
                'multiple'      => false,
                'expanded'      => false,
                'required'      => true
            ))

            ->add('plainPassword',RepeatedType::class, array(
                'type'            => PasswordType::class,
                'options'         => array('translation_domain' => 'FOSUserBundle'),
                'first_options'   => array(
                    'label' => 'form.password',
                    'attr'  => array(
                        'minleght'    => 6,
                        'placeholder' => 'Mot de passe'
                    )
                ),
                'second_options'  => array(
                    'label' => 'form.password_confirmation',
                    'attr'  => array(
                        'placeholder' => 'Confirmation mot de passe'
                    )
                ),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Techzara\Service\UserBundle\Entity\User',
            'user_role'  => null
        ));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tz_userbundle_user';
    }
}
