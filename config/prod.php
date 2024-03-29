<?php

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
        'db.options' => array(
                'driver'   => 'pdo_sqlite',
                'path'     => __DIR__.'/../database.db',
        ),
));

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
        'security.firewalls' => array(
            'admin' => array(
                'pattern' => '^/in',
                'http' => true,
                'users' => array(
                    // raw password is foo
                    'latigid' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
                ),
            ),
        )
));

$app['mailgun.key'] = 'key-8onrdk6hkpapley7ullre4e-6dfyoeg8';
