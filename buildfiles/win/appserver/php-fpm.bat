@ECHO OFF
ECHO Starting PHP FastCGI...
php\php-cgi.exe -b ${php-fpm.host}:${php-fpm.port}