<?php


namespace App\Command;

use App\Import\CountriesImport;
use App\Import\ImportManager;
use App\Import\LeaguesByCountryImport;
use App\Import\LeaguesImport;
use App\Import\SportImport;
use App\Import\TeamsByLeagueImport;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class ImportCommand extends Command
{

    const feeds = [
        SportImport::type => 'https://www.thesportsdb.com/api/v1/json/1/all_sports.php',
        LeaguesImport::type => 'https://www.thesportsdb.com/api/v1/json/1/all_leagues.php',
        CountriesImport::type => 'https://www.thesportsdb.com/api/v1/json/1/all_countries.php',
        LeaguesByCountryImport::type => 'https://www.thesportsdb.com/api/v1/json/1/search_all_leagues.php?c=%s',
        TeamsByLeagueImport::type => 'https://www.thesportsdb.com/api/v1/json/1/search_all_teams.php?l=%s'
    ];

    protected static $defaultName = 'app:import';
    /**
     * @var ImportManager
     */
    private $importManager;

    public function __construct(ImportManager $importManager,string $name = null)
    {
        parent::__construct($name);
        $this->importManager = $importManager;
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new user.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a user...');

            $this->addArgument('type',InputArgument::REQUIRED, 'Import Type');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $type = $input->getArgument('type');
        if(!isset(self::feeds[$type])) return 0;

        $this->importManager->runImport($type);

        return 1;
    }
}