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
/lib/systemd/system/*

%changelog

%post
# Reload shared library list
ldconfig

# Create temporary directory
mkdir /opt/appserver/tmp

# Set needed files as accessable for the configured user
chown -R ${appserver.user}:${appserver.group} /opt/appserver/tmp
chown -R ${appserver.user}:${appserver.group} /opt/appserver/var
chown -R ${appserver.user}:${appserver.group} /opt/appserver/webapps
chown -R ${appserver.user}:${appserver.group} /opt/appserver/deploy
chmod -R 755 /opt/appserver

# Make the link to our system systemd file
ln -s /lib/systemd/system/appserver.service /etc/systemd/system/appserver.service
ln -s /lib/systemd/system/watcher.service /etc/systemd/system/watcher.service
ln -s /lib/systemd/system/appserver-fpm.service /etc/systemd/system/appserver-fpm.service

# Reload the systemd daemon
systemctl daemon-reload

# Start the appserver + watcher
systemctl start appserver.service
systemctl start watcher.service
systemctl start appserver-fpm.service

# Make them autostartable for the current runlevel
systemctl enable appserver.service
systemctl enable watcher.service
systemctl enable appserver-fpm.service