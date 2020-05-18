<?php
/**
 * @author <julienrajerison5@gmail.com>.
 */

namespace App\Controller\Front;

use App\Controller\AbstractBaseController;
use App\Repository\ChallengeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

/**
 * Class HomeController.
 */
class HomeController extends AbstractBaseController
{
    /**
     * @var
     */
    private $participants;

    /**
     * HomeController constructor.
     *
     * @param EntityManagerInterface       $entityManager
     * @param TokenGeneratorInterface      $tokenGenerator
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param ChallengeRepository          $participantsRepository
     */
    public function __construct(EntityManagerInterface $entityManager, TokenGeneratorInterface $tokenGenerator, UserPasswordEncoderInterface $userPasswordEncoder, ChallengeRepository $participantsRepository)
    {
        parent::__construct($entityManager, $tokenGenerator, $userPasswordEncoder);
    }

    /**
     * @Route("/", methods={"POST","GET"})
     */
    public function homePage()
    {
        return $this->render('front/_front_index.html.twig');
    }

    public function findAllParticipants()
    {

    }
}
