<?php
/**
 * @author <julienrajerison5@gmail.com>.
 */

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

/**
 * Class AbstractBaseController.
 */
class AbstractBaseController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var TokenGeneratorInterface */
    private $token;

    /** @var UserPasswordEncoderInterface */
    private $passEncoder;

    /**
     * AbstractBaseController constructor.
     *
     * @param EntityManagerInterface       $entityManager
     * @param TokenGeneratorInterface      $tokenGenerator
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(EntityManagerInterface $entityManager, TokenGeneratorInterface $tokenGenerator, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->em = $entityManager;
        $this->token = $tokenGenerator;
        $this->passEncoder = $userPasswordEncoder;
    }

    /**
     * @param object $object
     *
     * @return bool
     */
    public function save(object $object)
    {
        try {
            if (!$object->getId()) {
                $this->em->persist($object);
            }
            $this->em->flush();

            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @param object $object
     *
     * @return bool
     */
    public function remove(object $object)
    {
        try {
            if ($object) {
                $this->em->remove($object);
            }
            $this->em->flush();

            return true;
        } catch (Exception $exception) {
            return false;
        }
    }
}
