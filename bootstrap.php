<?php

$planckApplicationBootstrap = require(__DIR__.'/../__shared/__planckbootstrap/application-bootstrap.php');
$planckApplicationBootstrap->getAutoloader()->addNamespace('PlanckeyBlogPublic', __DIR__.'/source/class');





$planckApplicationBootstrap->registerVirtualPath(
    realpath(__DIR__.'/../__data/public'),
    __DIR__.'/www/data',
    'front-data'
);


$planckApplicationBootstrap->registerVirtualPath(
    realpath(__DIR__.'/../__data/backend'),
    __DIR__.'/data',
    'data'
);



return $planckApplicationBootstrap;








