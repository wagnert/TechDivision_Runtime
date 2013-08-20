<?php

define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);
define('BP', __DIR__);

// load composer namespaces and add them to the include path
$paths = array();
$namespaces = require __DIR__ . '/app/code/vendor/composer/autoload_namespaces.php';
foreach ($namespaces as $namespace) {
    $paths = array_merge($paths, $namespace);
}

// add the default include paths
$paths[] = __DIR__ . DS . 'app' . DS . 'code' . DS . 'local';
$paths[] = __DIR__ . DS . 'app' . DS . 'code' . DS . 'community';
$paths[] = __DIR__ . DS . 'app' . DS . 'code' . DS . 'core';
$paths[] = __DIR__ . DS . 'app' . DS . 'code' . DS . 'lib'; // directory for PEAR libraries

// set the new include path
set_include_path(get_include_path() . PS . implode(PS, $paths));

require __DIR__ . '/app/code/vendor/autoload.php';