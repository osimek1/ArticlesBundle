<?php

$file = __DIR__.'/../vendor/autoload.php';

if (!file_exists($file)) {
	$file = __DIR__.'/../../../../../autoload.php';
	if (!file_exists($file)){
		print_r($file);die();
		throw new RuntimeException('Install dependencies to run test suite. "php composer.phar install --dev"');
	}
}

require_once $file;