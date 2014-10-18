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

Now it is necessary to enable the library in `php.ini`:
```ini
extension=IcePHP.so 
```

Next you must add the Ice Library to your php include path:
```sh
/usr/share/Ice-3.4.2/php/lib
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

In the php configuration file, you can let the following line by default if the panel is on the same server as murmur:
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
$MyConfig['default_host'] = '127.0.0.1'; 
$MyConfig['default_port'] = 6502;
	
$MyConfig['ICE_Password'] = '';
	
$MyConfig['http_adress'] = 'http://127.0.0.1';
	
$MyConfig['default_language'] = 'en_EN';
	
$MyConfig['use_login_protection'] = false;
$MyConfig['Username'] = 'Username';
$MyConfig['Password'] = "Your password encrypted with md5"
```

You must fill correctly the field `'http_adress'` or the panel will not work properly.

Two language are available, English (en_EN) and French (fr_FR)

It's not necessary to fill the Username/Password until you fill default_host, default_port and ICE_Password
