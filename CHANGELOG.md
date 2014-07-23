# Version 0.8.2

## Bugfixes

* None

## Features

* [Issue #178](https://github.com/techdivision/TechDivision_ApplicationServer/issues/178) App-based context configuration
* Use DirectoryKeys to create path to appserver.xml + appserver.xsd in server.php
* Create new configuration directory structure etc/appserver + etc/appserver/conf.d
* Move appserver.xml to new configuration directory etc/appserver and context.xml to etc/appserver/conf.d

# Version 0.8.1

## Bugfixes

* Set environment variable LOGGER_ACCESS=Access in all servers

## Features

* Switch from techdivision/appserver minor version 0.7.* to 0.8.*
* Switch from techdivision/persistencecontainer minor version 0.7.* to 0.8.*
* Switch from techdivision/messagequeue minor version 0.6.* to 0.7.*
* Switch from techdivision/servletengine minor version 0.6.* to 0.7.*
* Switch from techdivision/websocketserver minor version 0.2.* to 0.3.*
* Add latest admin.phar and example.phar
* Add default context.xml configuration to etc/appserver.d directory
* Add mandatory name attribute for servers in XSD schema
* Replace vhost node with context node in XSD schema