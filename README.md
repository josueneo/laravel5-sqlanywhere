This project was abandoned as of 2022, it was developed as part of my job at SAP for an internal Laravel app.
Development for SQL Anywhere PDO driver seems to be stopped, however, there is support for PHP 8.2, 8.1, 8.0, 7.4, 7.3, 7.2 for prebuilt binaries, and source code is available at: 
https://help.sap.com/docs/SUPPORT_CONTENT/sqlany/3362971282.html

# laravel5-sqlanywhere 0.2.3

## A driver for SAP SQLAnywhere 17 for use with the laravel framework version 5.x

### Pre-requisites

1. You need the SQL Anywhere libraries installed in your server, fortunately there is a developer version available at https://www.sap.com/cmp/syb/crm-xu15-int-sqldevft/index.html


2. Build and install the PDO_SQLANYWHERE module from the PECL repo.

```bash
wget https://pecl.php.net/get/PDO_SQLANYWHERE -O PDO_SQLANYWHERE.tgz
phpize
./configure
make
make install
```

3. If using apache http server, the SQL Anywhere libraries path must exist in LD_LIBRARY_PATH.

###For Fedora/CentOS 7/RHEL 7

Override your httpd systemd script with

```
systemctl edit httpd
```

This will open your text editor, just add the below:
```
[Service]
Environment=LD_LIBRARY_PATH=/opt/sqlanywhere17/lib64
```

###For SLES 11 SP4 and below
Edit your sysconfig file and add it there

To be written.

###For SLES 12 GA and newer versions (Currently SLES 12 SP2)
Same strategy as Fedora, Centos or RHEL 7.

To be written.


## Installing driver

Install it via composer
```
composer require josueneo/laravel5-sqlanywhere
```

Add service provider, open config/app.php
```
josueneo\laravel5sqlanywhere\SQLAnywhereServiceProvider::class
```

Edit configuration at config/database.php
```
'sqlanywhere' => [
            'driver' => 'sqlanywhere',
            'dsn' => 'sqlanywhere:',
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', 'yourpassword'),
            'database' => env('DB_DATABASE_NAME', ''),
            'databasefile' => env('DB_DATABASE', ''),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '2638'),
            'options' => 'ASTOP=no'
        ]
```


Most of grammar files are based on the cgartner driver written for laravel 4.

