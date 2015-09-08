<?php
/**
 * QueryCommand.php
 *
 * Author: Larry Li <larryli@qq.com>
 */

namespace larryli\ipv4\Command;

use larryli\ipv4\Query\Query;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class QueryCommand
 * @package larryli\ipv4\Command
 */
class QueryCommand extends Command
{
    /**
     *
     */
    protected function configure()
    {
        $this->setName('query')
            ->setDescription('query ip')
            ->addArgument(
                'ip',
                InputArgument::REQUIRED,
                "ip v4 address");
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ip = $input->getArgument('ip');
        $output->writeln("<info>query \"{$ip}\":</info>");
        $ip = ip2long($ip);
        foreach (Query::config() as $query => $options) {
            $this->query($output, $query, $ip);
        }
    }

    /**
     * @param $output
     * @param $name
     * @param $ip
     * @throws \Exception
     */
    private function query($output, $name, $ip)
    {
        $query = Query::create($name);
        $address = $query->query($ip);
        $output->writeln("\t<comment>{$name}:</comment> {$address}");
    }

}
