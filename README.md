# Runtime

On Mac OS X, the runtime provides you with system independent, thread-safe compiled PHP environment. 
Besides the most recent PHP 5.5.x version the package came with statically compiled

* [pthreads](http://pecl.php.net/package/pthreads) 
* [memcached](http://pecl.php.net/package/memcached)
* [redis](http://pecl.php.net/package/redis)
* [appserver](https://github.com/techdivision/php-ext-appserver) (contains some replacement functions for XDebug)

PECL extensions. Additionally the PECL extensions [XDebug](http://pecl.php.net/package/xdebug) and [ev](http://pecl.php.net/package/ev) are compiled as a shared modules. XDebug is necessary to
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
