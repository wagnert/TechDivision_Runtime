@ECHO OFF
ECHO Executing postinstall script for appserver.io...

set php=php\php.exe
set ini=php\php.ini
set composer=bin\composer.phar

%php% -c %ini% %composer% run-script post-install-cmd