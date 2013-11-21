<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../src/app.php';
require __DIR__ . '/prod.php';

// Any way to access the EntityManager from your application
$em = $app['orm.em'];

$helperSet = new \Symfony\Component\Console\Helper\HelperSet ( array (
		'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper ( $em->getConnection () ),
		'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper ( $em ) 
) );