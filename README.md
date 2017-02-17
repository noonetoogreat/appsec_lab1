Application Security - Lab 1
=========

A simple web application that allow users to upload a PNG, JPG, or GIF image with a caption. Visitors to the site can view uploaded images. A simple, secure login and signup system with PHP, MySQL and jQuery (AJAX) using Bootstrap 3 for the form design.

## Installation

### Dependancies

> 1) Apache - 2.4.18
> 2) PHP - 5.6.23
> 3) MySQL - 14.14

### Download ajk665_webapp.tar.gz to your Document Root according to your Apache Setup.
    $ cd <enter path to your Document Root>
    $ tar -xvf ajk665_webapp.tar.gz

### (Alternate Option) Clone the Repository
    $ git clone https://github.com/noonetoogreat/appsec_lab1.git
    $ cd ..
    $ mv appsec_lab1 ajk665_webapp
    $ cd ajk665_webapp

### Setting up .htaccess for redirects
Paste the following into the .htaccess file
```
ErrorDocument 404 /ajk665_webapp/404.php
```

### Creating the MySQL Database

Create database "gallery" and create tables "members", "loginAttempts" and "images":

```sql
CREATE TABLE `members` (
  `id` char(23) NOT NULL,
  `username` varchar(65) NOT NULL DEFAULT '',
  `password` varchar(65) NOT NULL DEFAULT '',
  `email` varchar(65) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `mod_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `loginAttempts` (
  `IP` varchar(20) NOT NULL,
  `Attempts` int(11) NOT NULL,
  `LastLogin` datetime NOT NULL,
  `Username` varchar(65) DEFAULT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imagename` varchar(512) NOT NULL,
  `filename` varchar(512) NOT NULL,
  `filetype` varchar(20) NOT NULL,
  `filename_hash` varchar(512) NOT NULL,
  `user` varchar(23) NOT NULL,
  `uploadtime` int(11) NOT NULL,
  `comment` varchar(512) DEFAULT NULL,
  `server_uploadtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



```

### Setup the `login/config.php` file

```php
<?php

//SYSTEM SETTINGS
$base_url = 'http://' . $_SERVER['SERVER_NAME'];
$signin_url = substr($base_url . $_SERVER['PHP_SELF'], 0, -(6 + strlen(basename($_SERVER['PHP_SELF']))));

//REQUEST SETTINGS
$ip_address = $_SERVER['REMOTE_ADDR'];


//DATABASE CONNECTION VARIABLES
$host = "localhost"; // Host name
$username = "user"; // Mysql username
$password = "password"; // Mysql password
$db_name = "gallery"; // Database name

//TABLE VARIABLES
$tbl_prefix = ""; 
$tbl_members = $tbl_prefix."members";
$tbl_attempts = $tbl_prefix."loginAttempts";
$tbl_images = $tbl_prefix."images";

//Set this for global site use
$site_name = 'Gallery';

//LOGIN SETTINGS
//Maximum Login Attempts
$max_attempts = 5;
//Timeout (in seconds) after max attempts are reached
$login_timeout = 300;
$timeout_minutes = round(($login_timeout / 60), 1);

//GLOBAL ERROR MESSAGES
//LOGIN FORM RESPONSE MESSAGES/ERRORS
$signupthanks = 'Thank you for signing up! Please click on the Login button to login.';

//UPLOAD SETTINGS
//Upload Directory
$upload_directory = '../tmp/';
$max_upload_size = 1024*1024*1024;
$upload_error_message = "There has been an error in processing your form. Please try again.";
```


###Signup/Login Workflow:
> 1) Create new user using `signup.php` form
> (note: validation occurs both client and server side)
> &nbsp;&nbsp;&nbsp;&nbsp;<b>Validation requires: </b>
> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Passwords to match and be at least 4 characters
> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Valid email address
> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Unique username
> 2) Password gets hashed and new GUID is generated for User ID
> 3) User gets added to database
> 4) User may now log in

###Upload Workflow:
> 1) Login using `login.php` form
> 2) User is presented with all the images that were uploaded by them at profile.php.
> 3) Goto upload.php
> 4) Provide an image name, image, and an optional comment

###Delete/Update Comment Workflow:
> 1) Login using `login.php` form
> 2) User is presented with all the images that were uploaded by them at profile.php. User can modify the comment or delete the image as required.
> 3) Click on Delete under an image to delete.
> 4) Update the comment and click on Update Comment to update the comment

