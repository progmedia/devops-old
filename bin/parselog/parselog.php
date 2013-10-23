<?php
namespace ParseLog;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ParseLog extends Command
{
    protected static $patterns = [
        'apacheCombined' => [
            // regex pattern
            'pattern' =>
                // ip address            identd    auth      day    month   year   time                    TZ            request   http        code  size  referrer  navigator
                '/(\d+\.\d+\.\d+\.\d+) ([^\s]+) ([^\s]+) \[(\d+)\/(\w+)\/(\d+):(\d{1,2}:\d{1,2}:\d{1,2} ?[\+\-]?\d*)\] "(.*) (HTTP\/\d\.\d)" (\d+) (\d+) "([^"]*)" "([^"]*)"/',

            // matches
            'matches' => [
                1 => 'ip',
                2 => 'identd',
                3 => 'auth',
                4 => 'day',
                5 => 'month',
                6 => 'year',
                7 => 'time',
                8 => 'request',
                9 => 'http_version',
                10 => 'response_code',
                11 => 'size',
                12 => 'referrer',
                13 => 'navigator'
            ]
        ]
    ];

    /**
     * PDO Object
     * @var PDO
     */
    protected $pdo;

    /**
     * Input interface to console
     * @var InputInterface
     */
    protected $input;

    /**
     * Number of hits on search query
     * @var integer
     */
    protected $hits = 0;

    /**
     * Configure command
     */
    protected function configure()
    {
        $this
            ->setName('parselog')
            ->setDescription('Parses a log and performs a match on a given arguemnt')
            ->addArgument(
                'file',
                InputArgument::REQUIRED,
                'Log file'
            )
            ->addArgument(
                'match',
                InputArgument::REQUIRED,
                'String to search for within log file'
            )
            ->addOption(
                'type',
                null,
                InputOption::VALUE_REQUIRED,
                'Log type to process (default is apache)',
                'apacheCombined'
            );

        //$this->connectToMySQL();
    }

    /**
     * Top-level execution of command
     *
     * @param InputInterface    Console input
     * @param OutputInterface   Console output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;

        $output->writeln('<info>Searching ' . $input->getArgument('file') . " for '" . $input->getArgument('match') . "'</info>");

        $time_start = microtime(true);

        $this->parse();

        if ($this->hits == 0) {
            $output->writeln('No results, you lose!');
        }

        $time_end = microtime(true);
        $execution_time = $time_end - $time_start;

        $output->writeln('<error>' . $this->hits . ' Hits</error>');
        $output->writeln('Search completed in ' . round($execution_time, 2) . ' secs');
    }

    /**
     * Parses given log file
     */
    protected function parse()
    {
        $filename = $this->input->getArgument('file');
        $type = $this->input->getOption('type');

        if (!file_exists($filename) || !is_readable($filename)) {
            throw new \Exception('Input log file is not readable or does not exist (' . $filename . ')');
        }

        $fh = fopen($filename, 'r');

        try
        {
            while (!feof($fh)) {

                $line = fgets($fh);

                // if the line matches
                if (preg_match(self::$patterns[$type]['pattern'], $line, $matches)) {

                    $data = array();

                    // loop through the pattern's matches and set the data array correctly
                    foreach (self::$patterns[$type]['matches'] as $i => $key) {
                        $data[$key] = $matches[$i];
                    }

                    /*
                    $stmt = $this->pdo->prepare('INSERT INTO logs VALUES(:ip, :identd, :auth, :logDay, :logMonth, :logYear, :logTime, :request, :http_version, :response_code, :size, :referrer, :navigator)');

                    $stmt->execute(array(
                        ':ip'               => $data['ip'],
                        ':identd'           => $data['identd'],
                        ':auth'             => $data['auth'],
                        ':logDay'           => $data['day'],
                        ':logMonth'         => $data['month'],
                        ':logYear'          => $data['year'],
                        ':logTime'          => $data['time'],
                        //':request'          => str_replace('//', '/', substr($data['request'], 4)),
                        ':request'          => str_replace('//', '/', $data['request']),
                        ':http_version'     => $data['http_version'],
                        ':response_code'    => $data['response_code'],
                        ':size'             => $data['size'],
                        ':referrer'         => $data['referrer'],
                        ':navigator'        => $data['navigator']
                    ));
                    */

                    // search log row and increment hit if querystring found
                    if ($this->matchCount('request', $this->input->getArgument('match'), $data)) {
                        //echo $line . "\n";
                        $this->hits++;
                    }
                }
            }
        } catch(\PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

        # Processing
        fclose($fh);
    }

    /**
     * Searches an field in an array for a partial string match
     *
     * @param  string
     * @param  string
     * @param  array
     * @return boolean
     */
    protected function matchCount($field, $value, array $array)
    {
        // skip if our string is empty
        if (empty($array[$field])) {
            return false;
        }

        // remove request part of string + dupe slashes
        $logLine = str_replace('//', '/', substr($array[$field], 4));

        // perform match
        if (strpos($logLine, $value) === 0) {
            return true;
        }
    }

    /**
     * Creates PDO connection to Audry
     */
    protected function connectToMySQL()
    {
        try {
            $this->pdo = new \PDO('mysql:host=audry.videogamer.com;dbname=accesslogsjul13', 'stduser', 'Pn8jTAMaNrf7P24w');
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch(\PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
}
