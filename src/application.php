#!/usr/bin/env php
<?php
declare(strict_types=1);

require __DIR__.'/vendor/autoload.php';
require __DIR__ . '/WorldFirstMenuCommand.php';
require __DIR__.'/BankAccount.php';

use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new WorldFirstMenuCommand());
$application->run();
