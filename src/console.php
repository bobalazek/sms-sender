<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

$console = new Application('SMS Sender');
$console->getDefinition()->addOption(
    new InputOption(
        '--env',
        '-e',
        InputOption::VALUE_REQUIRED,
        'The Environment name.',
        'dev'
    )
);
$console->setDispatcher($app['dispatcher']);
$console
    ->register('process')
    ->setDescription('Starts the processing')
    ->setCode(
        function (
            InputInterface $input,
            OutputInterface $output
        ) use ($app) {
            // TODO
        }
    )
;

return $console;
