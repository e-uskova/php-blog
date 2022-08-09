<?php

use Slim\Factory\AppFactory;
use Blog\Route\AboutPage;
use Blog\Route\BlogPage;
use DI\ContainerBuilder;
use DevCoder\DotEnv;
use Blog\Route\HomePage;
use Blog\Route\PostPage;

require __DIR__ . '/vendor/autoload.php';

$builder = new ContainerBuilder();
$builder->addDefinitions('config/di.php');

(new DotEnv(__DIR__ . '/.env'))->load();

$container = $builder->build();

AppFactory::setContainer($container);

$app = AppFactory::create();

$app->get('/', HomePage::class . ':execute');
$app->get('/about', AboutPage::class);
$app->get('/blog[/{page}]', BlogPage::class);
$app->get('/{url_key}', PostPage::class);

$app->run();