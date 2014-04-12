@echo off
php\php -dappserver.php_sapi=appserver -dappserver.remove_functions=getenv,putenv server.php