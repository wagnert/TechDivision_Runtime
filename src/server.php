<?php

/**
 * server.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @category   Appserver
 * @package    TechDivision_Runtime
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://www.appserver.io
 */

namespace TechDivision\ApplicationServer;

declare (ticks = 1);

/**
 * Rewrite the SAPI to avoid invalid CLI SAPI detection for TYPO3 Flow for example
 * 
 * @see https://github.com/techdivision/php-ext-appserver#ini-settings
 */
error_reporting(~E_NOTICE);
set_time_limit (0);

// set the session timeout to unlimited
ini_set('session.gc_maxlifetime', 0);
ini_set('zend.enable_gc', 0);
ini_set('max_execution_time', 0);

// set environmental variables in $_ENV globals per default
$_ENV = appserver_get_envs();

// load core functions to override in runtime environment
require __DIR__ . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'scripts' . DIRECTORY_SEPARATOR . 'core_functions.php';

// bootstrap the application
require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

// initialize configuration and schema file name
$configurationFileName = APPSERVER_BP . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'appserver.xml';
$schemaFileName = APPSERVER_BP . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'appserver.xsd';

// initialize the DOMDocument with the configuration file to be validated
$configurationFile = new \DOMDocument();
$configurationFile->load($configurationFileName);

// activate internal error handling, necessary to catch errors with libxml_get_errors()
libxml_use_internal_errors(true);

// validate the configuration file with the schema
if ($configurationFile->schemaValidate($schemaFileName) === false) {
    foreach (libxml_get_errors() as $error) {
        $message = "Found a schema validation error on line %s with code %s and message %s when validating configuration file %s";
        error_log(var_export($error, true));
        throw new \Exception(sprintf($message, $error->line, $error->code, $error->message, $error->file));
    }
}

// initialize the SimpleXMLElement with the content XML configuration file
$configuration = new Configuration();
$configuration->initFromFile($configurationFileName);
$configuration->addChildWithNameAndValue('baseDirectory', APPSERVER_BP);

// create the server instance
$server = new Server($configuration);

// check if server.php has been started with -w option
$watch = 'w';
$arguments = getopt("$watch::");

// if -w option has been passed, watch deployment directory only
if (array_key_exists($watch, $arguments)) {
    $server->watch();
} else {
    $server->start();
}