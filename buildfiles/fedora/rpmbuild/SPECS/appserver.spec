%define        __spec_install_post %{nil}
%define          debug_package %{nil}
%define        __os_install_post %{_dbpath}/brp-compress

Name:		appserver
Version:	${appserver.version}
Release:	1%{?dist}
Summary:	Multithreaded Application Server für PHP, geschrieben in PHP
Group:		System Environment/Base
License:	OSS
URL:		www.appserver.io
SOURCE0:	%{name}-%{version}.tar.gz
requires:   git, libmcrypt, libmemcached, memcached

BuildRoot: %{_tmppath}/%{name}-%{version}-%{release}-root

%description
%{summary}

%prep

%setup -q

%build

%install
mkdir -p %{buildroot}/opt/appserver/

cp -ra * %{buildroot}/opt/appserver/

%clean
rm -rf %{buildroot}


%files
/opt/appserver/*

%changelog


%post
