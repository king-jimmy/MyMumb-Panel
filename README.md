MyMumb - Panel
=============

### Softwares
You will need the following softwares:

* Apache 2.X.X
 * mod_rewrite
* PHP 5.5.X
* Zeroc ICE

### Installation of Zeroc ICE
First you need to install Zeroc Ice by typing the following command in your shell:
```Shell
apt-get install php-zeroc-ice
```

Now it is necessary to enable the lib in the php.ini
```
extension=IcePHP.so 
```

Next you must add the Ice Lib to your php include path
```
/usr/share/Ice-3.4.2/php/lib
```

### Enable the mod_rewrite
You can enable the mod_rewrite by typing the command
```Shell
a2enmod rewrite
```

It's not finish yet, you must change something in your vhost configuration.
You must turn the AllowOverride to 'All'

### Murmur Configuration
Before continuing you must prepare your murmur to use Ice.

You can let the following line by default if the panel is on the same server of the murmur server
```
ice="tcp -h 127.0.0.1 -p 6502"
```

It is necessary to set a password for the ice connection
```
icesecretwrite=<your password>
```

### Panel Configuration
Now open the config.inc.php file and edit it as you want
```
$MyConfig['default_host'] = '127.0.0.1'; 
$MyConfig['default_port'] = 6502;
	
$MyConfig['ICE_Password'] = '';
	
$MyConfig['http_adress'] = 'http://127.0.0.1';
	
$MyConfig['default_language'] = 'en_EN';
	
$MyConfig['use_login_protection'] = false;
	$MyConfig['Username'] = 'Username';
	$MyConfig['Password'] = "Your password encrypted with md5"
```

You must fill correctly the field 'http_adress' or the panel will not work correctly.

Two language is available, the French (fr_FR) and the English (en_EN)

It's not necessary to fill the Username/Password until you fill default_host, default_port and ICE_Password
