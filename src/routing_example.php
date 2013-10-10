<?php

// bootstrap the application
require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

//Set the include path so that the Routing library files can be included.
set_include_path(get_include_path() . PATH_SEPARATOR . '/path/to/php-router');

//Include a PageError class which can be used later. You supply this class.
include('PageError.php');
include('php-router.php');

//Create a new instance of Router (you'd likely use a factory or container to
// manage the instance)
$router = new Router;

//Get an instance of Dispatcher
$dispatcher = new Dispatcher;
$dispatcher->setSuffix('Controller');
$dispatcher->setClassPath('/path/to/controllers/');

//Set up a 'catch all' default route and add it to the Router.
//You may want to set up an external file, define your routes there, and
// and include that file in place of this code block.
$std_route = new Route('/:class/:method/:id');
$std_route->addDynamicElement(':class', ':class')
          ->addDynamicElement(':method', ':method')
          ->addDynamicElement(':id', ':id');
$router->addRoute( 'std', $std_route );

//Set up your default route:
$default_route = new Route('/');
$default_route->setMapClass('default')->setMapMethod('index');
$router->addRoute( 'default', $default_route );

$url = urldecode($_SERVER['REQUEST_URI']);

try {
    $found_route = $router->findRoute($url);
    $dispatcher->dispatch( $found_route );
} catch ( RouteNotFoundException $e ) {
    PageError::show('404', $url);
} catch ( badClassNameException $e ) {
    PageError::show('400', $url);
} catch ( classFileNotFoundException $e ) {
    PageError::show('500', $url);
} catch ( classNameNotFoundException $e ) {
    PageError::show('500', $url);
} catch ( classMethodNotFoundException $e ) {
    PageError::show('500', $url);
} catch ( classNotSpecifiedException $e ) {
    PageError::show('500', $url);
} catch ( methodNotSpecifiedException $e ) {
    PageError::show('500', $url);
}