# Roadmap

Version 0.6

* Integrate Monolog Logger
* Integration Annotations for session beans
* PHPUnit test suite for TechDivision_ApplicationServer project
* AOP
* DI

* Running Magento CE 1.7.x demo application
* Running TYPO3 demo application
* Running TYPO3 Flow 2.0.x demo application
* Running TYPO3 Neos 1.x demo application

Version 0.7

* Merging XML configuration files
* Automated Build- and Deployment using Travis-CI
* Timer Service
* Container based caching for Doctrine entity beans
* SSL Encryption for TechDivision_ServletContainer project
* HTTP basic authentication for TechDivision_ServletContainer project
* PHPUnit test suite for TechDivision_ServletContainer project

Version 0.8

* Distributed and redundant cluster caching system with automated failover
* PHPUnit test suite for TechDivision_PersistenceContainer project
* Webservice for session beans

Version 0.9

* Fast-CGI container
* WebSocket integration
* PHAR based deployment
* PHPUnit test suite for TechDivision_MessageQueue project

Version 1.0

* Transaktionen
* Cluster functionality
* Farming deployment

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