<?php

define('APPSERVER_BP', __DIR__);

// load composer namespaces and add them to the include path
$paths = array();
$namespaces = require APPSERVER_BP . '/app/code/vendor/composer/autoload_namespaces.php';
foreach ($namespaces as $namespace) {
    $paths = array_merge($paths, $namespace);
}

// add the default include paths
$paths[] = APPSERVER_BP . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'code' . DIRECTORY_SEPARATOR . 'local';
$paths[] = APPSERVER_BP . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'code' . DIRECTORY_SEPARATOR . 'community';
$paths[] = APPSERVER_BP . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'code' . DIRECTORY_SEPARATOR . 'core';
$paths[] = APPSERVER_BP . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'code' . DIRECTORY_SEPARATOR . 'lib'; // directory for PEAR libraries

// set the new include path
set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $paths));

require APPSERVER_BP . '/app/code/vendor/autoload.php';