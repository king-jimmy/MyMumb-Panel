MyMumb - Panel
=============

### Prerequisites:

    * Apache 2 or newer with mod_rewrite enabled
    * PHP 5.5 or newer
    * Zeroc ICE

##### Installation of Zeroc ICE
First you need to install Zeroc Ice:
```sh
apt-get install zeroc-ice php-zeroc-ice
```

Now you have to enable the library for PHP and add the Library itself to the include Path of PHP.

You can do this in the 20-IcePHP.ini This file should be located in the /etc/php5/apache2/conf.d/ directory

```sh
include_path=/usr/share/Ice-3.5.1/php/lib
extension=IcePHP.so
```

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

## Required files generation
Now you have to generate the `murmur.php`

If you have installed murmur by the apt-get command :
```sh
slice2php -I/usr/share/Ice-3.5.1/slice/ --ice /usr/share/murmur/Murmur.ice
cp /usr/share/murmur/Murmur.php <"PanelPath"/inc/Murmur.php>
```
(The Path for Ice could differ here. Use the one which fits you. 
Please leave the -I at the beginning since it specifies the Input)

If not, you have to go in the directory of your murmur server
Then go in the folder 'ice'
```sh
slice2php -I/usr/share/Ice-3.5.1/slice/ --ice Murmur.ice
cp Murmur.php <"PanelPath"/inc/Murmur.php>
```

And 'Voila' your panel is ready to be use.

