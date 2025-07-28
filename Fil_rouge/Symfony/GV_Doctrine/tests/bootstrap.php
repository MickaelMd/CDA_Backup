<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}

if ($_ENV['APP_ENV'] === 'test') {
    passthru('php bin/console doctrine:database:drop --env=test --force --if-exists');
    passthru('php bin/console doctrine:database:create --env=test --if-not-exists');
    passthru('php bin/console doctrine:schema:update --env=test --force');
    passthru('php bin/console doctrine:fixtures:load --env=test --no-interaction');
}