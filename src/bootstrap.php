<?php

define('APPSERVER_DS', DIRECTORY_SEPARATOR);
define('APPSERVER_PS', PATH_SEPARATOR);
define('APPSERVER_BP', __DIR__);

// load composer namespaces and add them to the include path
$paths = array();
$namespaces = require APPSERVER_BP . '/app/code/vendor/composer/autoload_namespaces.php';
foreach ($namespaces as $namespace) {
    $paths = array_merge($paths, $namespace);
}

// add the default include paths
$paths[] = APPSERVER_BP . APPSERVER_DS . 'app' . APPSERVER_DS . 'code' . APPSERVER_DS . 'local';
$paths[] = APPSERVER_BP . APPSERVER_DS . 'app' . APPSERVER_DS . 'code' . APPSERVER_DS . 'community';
$paths[] = APPSERVER_BP . APPSERVER_DS . 'app' . APPSERVER_DS . 'code' . APPSERVER_DS . 'core';
$paths[] = APPSERVER_BP . APPSERVER_DS . 'app' . APPSERVER_DS . 'code' . APPSERVER_DS . 'lib'; // directory for PEAR libraries

// set the new include path
set_include_path(get_include_path() . APPSERVER_PS . implode(APPSERVER_PS, $paths));

require APPSERVER_BP . '/app/code/vendor/autoload.php';