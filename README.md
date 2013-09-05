# Runtime

On Mac OS X, the runtime provides you with system independent, thread-safe compiled PHP environment. 
Besides the most recent PHP 5.5.x version the package came with the statically compiled

* pthreads
* memcached
* redis
* appserver (contains some replacement functions for XDebug)

PECL extensions. Additionally XDebug and ev are compiled as a shared module. XDebug is necessary to
render detailed code coverage reports when running unit and intergration tests. ev will be used to
integrate a timer service in one of the future versions.

# Installation

To build the runtime on Mac OS X you need the following tools:

* XCode commandline tools (can be installed from the App Store)
* automake (Download from http://www.gnu.org/software/autoconf/)
* autoconf (Download from http://www.gnu.org/software/automake/)

After that, change your workspace and clone the sources from our GitHub repository with
	
```
$ git clone https://github.com/techdivision/TechDivision_Runtime.git
```

Change into the project directory and start the build using ANT:

	
```
$ cd TechDivision_Runtime
$ ant create-pkg
```

After compiling the runtime you'll find the installable .pkg file in the target directory.


# Roadmap

Version 0.6 [Application Server]

* Logging
* AOP
* DI
* Refactoring routing
* Merging XML configuration files
* Separate configuration files for server, container and application
* Set environment variables in XML configuration files
* PHAR based deployment
* 100 % Coverage for PHPUnit test suite for TechDivision_ApplicationServer project
* Automated Build- and Deployment using Travis-CI
* Running Magento CE 1.7.x demo application
* Running TYPO3 6.x demo application
* Running TYPO3 Flow 2.0.x demo application
* Running TYPO3 Neos 1.x demo application
* Mac OS X Universal installer
* rpm Packages
* Windows installer

Version 0.7 [Servlet Container]

* Integrate annotations for session beans
* Administration interface with drag-and-drop PHAR installer
* SSL Encryption for TechDivision_ServletContainer project
* HTTP basic authentication for TechDivision_ServletContainer project
* mod_rewrite functionality for TechDivision_ServletContainer project
* Add dynamic load of application specific PECL extensions
* 100 % Coverage for PHPUnit test suite for TechDivision_ServletContainer project

Version 0.8 [Persistence Container]

* Stateful + Singleton session bean functionality
* Container managed entity beans for Doctrine
* Webservice for session beans
* 100 % Coverage for PHPUnit test suite for TechDivision_PersistenceContainer project

Version 0.9 [Message Queue]

* Message bean functionality
* 100 % Coverage for PHPUnit test suite for TechDivision_MessageQueue project

Version 1.0 [Timer Service]

* Timer Service
* 100 % Coverage for PHPUnit test suite for TechDivision_TimerService project

-------------------- CE ------------------------------------------------------------------

Version 1.1 [Cluster Functionality]

* Cluster functionality
* Container based transactions
* Farming deployment

-------------------- EE ------------------------------------------------------------------

Version 1.2 [Additional Containers]

* Distributed and redundant cluster caching system with automated failover
* Fast-CGI container
* WebSocket integration
