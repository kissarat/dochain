<?php
/**
 * Last modified: 18.07.10 04:41:27
 * Hash: a403ddad6fe1a3b9ee4c5124f639c9e7262e4583
 */

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

define('SITE', __DIR__);

require_once SITE . '/../vendor/autoload.php';

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(SITE . '/src'), $isDevMode, null, null, false);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

// database configuration parameters
$conn = require 'db.php';

// obtaining the entity manager
try {
    $entityManager = EntityManager::create($conn, $config);

} catch (\Doctrine\ORM\ORMException $e) {
    die(__FILE__ . ', line ' . __LINE__ . ': ' . $e->getMessage());
}
