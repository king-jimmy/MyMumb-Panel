You have two Murmur ICE * files in this folder. 
Choose the one for your installed Version of ICE.
Most Users should be able to work with the Version 3.4.2
If thats not working and you can not login try 3.5.1

If that one is not working too you need to create your own custom one.

This is the way i did it for the 3.5.1 Version.
Change it so it fits your needs.

This was done on Linux.



Change to the inc directory where this README is located.

cp /usr/share/murmur/Murmur.ice murmur_1.2.5.ice 
slice2php -I/usr/share/Ice-3.5.1/slice/ --ice murmur_1.2.5.ice

(The Path for Ice could differ here. Use the one which fits you. 
Please leave the -I at the beginning since it specifies the Input)

After that rm murmur_1.2.5.ice 

You now should have a murmur_1.2.5.ice.php in your folder.

Delete the old Murmur.php or rename it to the Version before 
and change the Name of your newly created murmur_*.ice.php to Murmur.php

You should now be able to login.



Thanks for this to shmap from the mumb1e forums.