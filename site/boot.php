<?php
/**
 * Last modified: 18.07.10 09:01:46
 * Hash: b6465e61cb2e52fa35434f251dc14c8628eecd86
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
/**
 * @var EntityManager
 */
$entityManager = null;
try {
    $entityManager = EntityManager::create($conn, $config);

} catch (\Doctrine\ORM\ORMException $e) {
    die(__FILE__ . ', line ' . __LINE__ . ': ' . $e->getMessage());
}
