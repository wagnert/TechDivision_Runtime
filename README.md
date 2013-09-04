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

# Default PHP compile settings
	
```
appserver.compile.configuration = --prefix=${appserver.compile.prefix} \
								  --libdir=${appserver.compile.prefix}/lib \
								  --disable-debug \
								  --disable-rpath \
								  --with-pic \
								  --with-gnu-ld \
								  --with-mysql \
								  --with-gd \
								  --with-jpeg-dir \
								  --with-png-dir \
								  --with-freetype-dir \
								  --with-zlib \
								  --with-bz2 \
								  --with-curl \
			 					  --with-mysqli \
								  --with-tsrm-pthreads \
								  --with-mcrypt \
								  --with-mysqli \
								  --with-openssl \
								  --with-pdo-mysql \
								  --with-pear=${appserver.compile.prefix}/app/code/lib \
								  --with-libdir=${appserver.compile.libdir} \
								  --with-config-file-path=${appserver.compile.prefix}/etc \
								  --with-config-file-scan-dir=${appserver.compile.prefix}/etc/conf.d \
								  --with-pcre-regex \
								  --with-jpeg-dir=${libjpeg.dir} \
								  --with-png-dir=${libpng.dir} \
								  --with-freetype-dir=${libfreetype.dir} \
								  --with-libmemcached-dir=${libmemcached.dir} \
								  --enable-static \
								  --enable-shared \
								  --enable-exif \
								  --enable-inline-optimization \
								  --enable-xml \
								  --enable-simplexml \
								  --enable-filter \
								  --enable-libxml \
								  --enable-session \
								  --enable-sockets \
								  --enable-mbstring \
								  --enable-gd-native-ttf \
								  --enable-bcmath \
								  --enable-zip \
								  --enable-phar \
								  --enable-pdo \
								  --enable-roxen-zts \
								  --enable-pcntl \
								  --enable-fpm \
								  --enable-maintainer-zts \
								  --enable-pthreads=static \
								  --enable-memcached=static \
								  --enable-redis=static \
```
