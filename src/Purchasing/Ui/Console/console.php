#!/usr/bin/env php
<?php

require __DIR__.'/../../../../vendor/autoload.php';

use Symfony\Component\Console\Application;
use Zend\ServiceManager\ServiceManager;

$containerConfig = require __DIR__.'/../../../../config/container.php';
$container = new ServiceManager($containerConfig);

$application = new Application('Selleet', 'alpha');

$application->add(new \Selleet\Purchasing\Ui\Console\AddJewelToCartCommand($container));
$application->add(new \Selleet\Purchasing\Ui\Console\InitFixturesCommand($container));

$application->run();
