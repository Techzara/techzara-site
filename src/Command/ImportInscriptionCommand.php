<?php
/**
 * @author <julienrajerison5@gmail.com>.
 */
namespace App\Command;

use App\Manager\ImportationManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ImportInscriptionCommand.
 */
class ImportInscriptionCommand extends Command
{
    /** @var ImportationManager */
    private $manager;

    /**
     * ImportInscriptionCommand constructor.
     *
     * @param ImportationManager $manager
     * @param string|null        $name
     */
    public function __construct(ImportationManager $manager, string $name = null)
    {
        parent::__construct($name);
        $this->manager = $manager;
    }

    /** @var string */
    protected static $defaultName = 'import:extract';

    /** Configure command */
    protected function configure()
    {
        $this
            ->setDescription('Importation inscription via csv file')
            ->addArgument('name', InputArgument::OPTIONAL, 'Challenge name');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     *
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('name');

        $this->manager->importData($io, $arg1);
        $io->success('Importation effectué avec success.');

        return 0;
    }
}
