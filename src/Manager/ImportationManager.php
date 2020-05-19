<?php
/**
 * @author <julienrajerison5@gmail.com>.
 */

namespace App\Manager;

use App\Entity\Challenge;
use App\Entity\Participants;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class ImportationManager.
 */
class ImportationManager
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var ParameterBagInterface */
    private $parameters;

    /**
     * ImportationManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param ParameterBagInterface  $parameterBag
     */
    public function __construct(EntityManagerInterface $entityManager, ParameterBagInterface $parameterBag)
    {
        $this->em = $entityManager;
        $this->parameters = $parameterBag;
    }

    /**
     * @param SymfonyStyle $symfonyStyle
     * @param string|null  $name
     *
     * @throws \Exception
     */
    public function importData(SymfonyStyle $symfonyStyle, ?string $name)
    {
        $file = $this->parameters->get('path_to_extract');
        if (file_exists($file)) {
            $i = 0;
            $h = fopen($file, "r");
            $challenge = new Challenge();

            $challenge->setStart(\DateTime::createFromFormat('d/m/Y', '23/05/2020'))->setEnd(\DateTime::createFromFormat('d/m/Y', '28/06/2020'));
            while (($data = fgetcsv($h, 1000, ',')) !== false) {
                if ($i >= 1) {
                    $participants = new Participants();
                    $participants
                        ->setPseudo($data[2])
                        ->setChoice($data[4])
                        ->setIsActif(true);
                    $challenge->addParticipant($participants);

                    $symfonyStyle->success($participants->getPseudo());
                }
                ++$i;
            };
            $challenge->setIsActif(true);
            $challenge->setName($name ?? 'Challenge-1');

            $this->em->persist($challenge);
            $this->em->flush();
        }
    }
}
