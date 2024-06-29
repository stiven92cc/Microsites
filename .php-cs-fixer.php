<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('bootstrap')
    ->exclude('config')
    ->exclude('node_modules')
    ->exclude('public')
    ->exclude('storage')
    ->exclude('vendor');

$config = new PhpCsFixer\Config();
$config->setRules([
    '@PSR12' => true,
])
    ->setFinder($finder);

return $config;
