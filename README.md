MyMumb - Panel
=============

### Prerequisites:

    * Apache 2 or newer with mod_rewrite enabled
    * PHP 5.5 or newer
    * Zeroc ICE

##### Installation of Zeroc ICE
First you need to install Zeroc Ice:
```sh
apt-get install php-zeroc-ice
```

Now you have to enable the library for PHP and add the Library itself to the include Path of PHP.

You can do this in the 20-IcePHP.ini This file should be located in the /etc/php5/apache2/conf.d/ directory

```sh
include_path=/usr/share/Ice-3.5.1/php/lib
extension=IcePHP.so
```

#### Enabling mod_rewrite

You can enable the mod_rewrite by typing :
```sh
a2enmod rewrite
```

It's not finished yet, you must change your vhost configuration.
You must turn the AllowOverride to 'All'

### Murmur Configuration
Before continuing you must configure murmur to use Ice.

Now you need to set the Settings in Mumble itself so the Webinterface and Server can communicate.
You can do this in the mumble-server.ini found in the folder /etc/ (This should be the case on Debian and Ubuntu when installing via apt-get)


Change this only if the Mumble Server is on a different Server.
```ini
ice="tcp -h 127.0.0.1 -p 6502"
```

It is necessary to set a password for the ice connection
```ini
icesecretwrite=<your password>
```

### Panel Configuration
Now open `config.inc.php` and edit it as you want
```php
	$MyConfig['default_host'] = '127.0.0.1'; //Ip of your Mumble Server. If its the same Server no need to change it.
	$MyConfig['default_port'] = 6502; //The Port of your Mumble Server

	$MyConfig['ICE_Password'] = 'icesecret'; //The Password used in the mumble-server.ini 

	$MyConfig['default_language'] = 'en_EN'; //Change the Language currently supported en_EN fr_FR de_DE

	$MyConfig['use_login_protection'] = false; //Change to true if you want to use a Username and password and not the ICE Secret
	$MyConfig['Username'] = 'Username';
	$MyConfig['Password'] = 'MD5 Decrypted Password';
```

Three languages are available, English (en_EN), German (de_DE) and French (fr_FR).


Now you need to change which Murmur.php you are using.
Since you already are in the inc directory change the Name of the Murmur ICE X.X.X.php 
which is aplicable for your version of ICE to Murmur.php

Most users should be able to use the 3.4.2 one. If that login wont work try the 3.5.1 instead.

If both are not working and you have a different ICE Version then 3.4.2 or 3.5.1 you have to create the
Murmur.php manually. This can be done on Linux this way:

You have to change the sections for the ICE Version to fit your directorys and needs.


Change to the inc directory where this README is located.

```sh
cp /usr/share/murmur/Murmur.ice murmur_1.2.5.ice 
slice2php -I/usr/share/Ice-3.5.1/slice/ --ice murmur_1.2.5.ice
```

(The Path for Ice could differ here. Use the one which fits you. 
Please leave the -I at the beginning since it specifies the Input)

After that
 
```sh
rm murmur_1.2.5.ice 
```

You now should have a murmur_1.2.5.ice.php in your folder.

Delete the old Murmur.php or rename it to the Version before 
and change the Name of your newly created murmur_*.ice.php to Murmur.php

You should now be able to login.



Thanks for this to shmap from the mumb1e forums. Source: http://www.mumb1e.de/en/forum/8-support/1539-blank-page#2048