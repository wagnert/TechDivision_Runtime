%define         _unpackaged_files_terminate_build 0
%define        __spec_install_post %{nil}
%define          debug_package %{nil}
%define        __os_install_post %{_dbpath}/brp-compress

Name:		appserver
Version:	${appserver.version}
Release:	${build.number}.${os.qualified.name}
Summary:	Multithreaded Application Server für PHP, geschrieben in PHP
Group:		System Environment/Base
License:	OSL 3.0
URL:		www.appserver.io
requires:   git, libmcrypt
Provides:   appserver

%description
%{summary}

%prep

%build

%clean

%files
/opt/appserver/*
/etc/init.d/*

%changelog

%post
# Reload shared library list
ldconfig

# Create temporary directory
mkdir /opt/appserver/tmp
mkdir /opt/appserver/etc/php-fpm.d

# Set needed files as accessable for the configured user
chown -R ${service.user}:${service.group} /opt/appserver/tmp
chown -R ${service.user}:${service.group} /opt/appserver/var
chown -R ${service.user}:${service.group} /opt/appserver/webapps
chown -R ${service.user}:${service.group} /opt/appserver/deploy
chmod -R 775 /opt/appserver

chmod 775 /etc/init.d/appserver
chmod 775 /etc/init.d/watcher
chmod 775 /etc/init.d/appserver-fpm

/etc/init.d/appserver start
/etc/init.d/watcher start
/etc/init.d/appserver-fpm start