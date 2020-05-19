<?php
/**
 * @author <julienrajerison5@gmail.com>.
 */

namespace App\Controller\Front;

use App\Controller\AbstractBaseController;
use App\Entity\Challenge;
use App\Repository\ChallengeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

/**
 * Class HomeController.
 */
class HomeController extends AbstractBaseController
{
    /**
     * @var ChallengeRepository
     */
    private $challengeRepository;

    /**
     * HomeController constructor.
     *
     * @param EntityManagerInterface       $entityManager
     * @param TokenGeneratorInterface      $tokenGenerator
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param ChallengeRepository          $challengeRepository
     */
    public function __construct(EntityManagerInterface $entityManager, TokenGeneratorInterface $tokenGenerator, UserPasswordEncoderInterface $userPasswordEncoder, ChallengeRepository $challengeRepository)
    {
        parent::__construct($entityManager, $tokenGenerator, $userPasswordEncoder);
        $this->challengeRepository = $challengeRepository;
    }

    /**
     * @Route("/", methods={"POST","GET"})
     */
    public function homePage()
    {
        return $this->render('front/_front_index.html.twig');
    }

    /**
     * @Route("/wcc", name="wcc_accueil", methods={"POST","GET"})
     */
    public function allChallenge()
    {
        $challenges = $this->challengeRepository->findAll();

        return $this->render('front/contest/_wcc_section.html.twig', ['challenges' => $challenges]);
    }

    /**
     * @Route("/wcc/{challenge?}", name="wcc_participants", methods={"POST","GET"})
     *
     * @param Challenge $challenge
     *
     * @return Response
     */
    public function participantsByChallenge(Challenge $challenge)
    {
        return $this->render(
            'front/contest/_participants.html.twig',
            [
                'participants' => $challenge->getParticipants(),
                'challenge' => $challenge,
            ]
        );
    }
}
