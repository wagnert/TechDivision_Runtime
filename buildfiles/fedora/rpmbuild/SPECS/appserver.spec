%define         _unpackaged_files_terminate_build 0
%define        __spec_install_post %{nil}
%define          debug_package %{nil}
%define        __os_install_post %{_dbpath}/brp-compress

Name:		appserver
Version:	${appserver.version}
Release:	${env.BUILD_NUMBER}.${os.qualified.name}
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
/lib/systemd/system/*

%changelog

%post
# Reload shared library list
ldconfig

# Set needed files as executable
chmod -R 755 /opt/appserver

# Make the link to our system systemd file
ln -s /lib/systemd/system/appserver.service /etc/systemd/system/appserver.service
ln -s /lib/systemd/system/watcher.service /etc/systemd/system/watcher.service

# Reload the systemd daemon
systemctl daemon-reload

# Start the appserver + watcher
systemctl start appserver.service
systemctl start watcher.service
