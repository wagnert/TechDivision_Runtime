<?php

namespace TechDivision\ApplicationServer;

declare (ticks = 1);

error_reporting(~E_NOTICE);
set_time_limit (0);

// set the session timeout to unlimited
ini_set('session.gc_maxlifetime', 0);
ini_set('zend.enable_gc', 0);
ini_set('max_execution_time', 0);

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

// start the server finally
$server = new Server($configuration);
$server->start();