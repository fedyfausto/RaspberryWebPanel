RaspberryWebPanel
=================

Web panel for the administration and management of your Debian and Raspberry server.


Requirements:

You'll need to have installed in your Apache 2 server and have a user who has full power of reading and writing.

How to install:

First create a folder inside your "/var/www/" where you want to put this panel, after uploading all the files within this folder, open the config.php file for the latest configuration (currently only the 'URL of the log that you want to view in the Dashboard).
Within the same file config.php create a user within the array by entering a username and password is encrypted in MD5.
