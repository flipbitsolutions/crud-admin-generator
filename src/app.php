<?php

/*
 * This file is part of the CRUD Admin Generator project.
 *
 * Author: Jon Segador <jonseg@gmail.com>
 * Web: http://crud-admin-generator.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Silex\Application;

$app = new Application();

$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.messages' => array(),
));
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new DerAlex\Silex\YamlConfigServiceProvider(__DIR__ . '/settings.yml'));
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(

        'dbs.options' => array(
            'db' => array(
                'driver'   => 'pdo_mysql',
                'dbname'   => $app['config']['dbconfig']['dbname'],
                'host'     => $app['config']['dbconfig']['host'],
                'user'     => $app['config']['dbconfig']['user'],
                'password' => $app['config']['dbconfig']['pass'],
                'charset'  => 'utf8',
            ),
        )
));
$app['login_path'] = '/login';
$app['login_check'] = '/secure/login_check';
$app['logout_path'] = '/secure/logout';
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'login' => array(
            'pattern' => '^'.$app['login_path'].'$',
        ),
        'secured' => array(
            'pattern' => '^.*$',
            'form' => array('login_path' => $app['login_path'], 'check_path' => $app['login_check']),
            'logout' => array('logout_path' => $app['logout_path']),
            'users' => array(
                'admin' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
            ),
        ),
    )
));
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../web/views',
));

$app['asset_path'] = $app['config']['asset_path'];
$app['debug'] = true;

return $app;
