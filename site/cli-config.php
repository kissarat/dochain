<?php
/**
 * Last modified: 18.07.10 03:50:20
 * Hash: cd172319afe379141d5c0a4e7993ef9fac6a9c43
 */

require_once 'boot.php';

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
