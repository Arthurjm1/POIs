<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

if (false) { 
	$containerBuilder->enableCompilation(__DIR__ . '/../var/cache');
}

$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);

$container = $containerBuilder->build();

AppFactory::setContainer($container);
$app = AppFactory::create();
$callableResolver = $app->getCallableResolver();

$db = $app->getContainer()->get('db');

$query = 'create table POIs (id int not null primary key auto_increment, nome varchar(150) not null, x int not null, y int not null)';
$stmt = $db->prepare($query);
$stmt->execute();
