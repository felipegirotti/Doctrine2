<?php

use Doctrine\ORM\Tools\Setup,
Doctrine\ORM\EntityManager,
Doctrine\ORM\Configuration,
Doctrine\Common\Cache\ArrayCache as Cache,
Doctrine\Common\Annotations\AnnotationRegistry,
Doctrine\Common\ClassLoader;

$conn = parse_ini_file(__DIR__ . DS . 'config.ini');

$config = new Configuration();
$cache = new Cache();
$config->setMetadataCacheImpl($cache);
AnnotationRegistry::registerFile(__DIR__ . '/library/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');
$driver = new Doctrine\ORM\Mapping\Driver\AnnotationDriver(
    new Doctrine\Common\Annotations\AnnotationReader(),
    array(__DIR__ . DS . 'Application' . DS.  'Entities')
);
$config->setMetadataDriverImpl($driver);
$config->setProxyDir(__DIR__ . DS . 'Application' . DS . 'Proxies');
$config->setProxyNamespace('Application\Proxies');

$entityManager = EntityManager::create($conn, $config);

$GLOBALS['em'] = $entityManager;
