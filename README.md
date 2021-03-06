# RentIt

<p align="center">
  <img src="https://github.com/alehee/RentIt/blob/main/_localonly/banner.png">
</p>

## Description
*RentIt* is an universal web platform for rent-a-thing purposes written in PHP with Bootstrap and JQuery with admin control panel, easy to use UI and cool stuff like top lists. Manage your rental business with this light platform, create items to rent and let the platform handle the orders system. Users will be pleased with this solution!

## How it works?
Customer can view full list of items on *order* page. User can toggle through categories and items to find something interesting.
<p align="center">
  <img src="https://github.com/alehee/RentIt/blob/main/_localonly/rentit-order.png">
</p>

Creating new order will trigger mail system for customer and administrator to inform about new order and give opportunity to cancel the order for user.
<p align="center">
  <img src="https://github.com/alehee/RentIt/blob/main/_localonly/rentit-mail.png">
</p>

You as an administrator have to manage the website from **admin panel**.
<p align="center">
  <img src="https://github.com/alehee/RentIt/blob/main/_localonly/rentit-admin-2.png">
</p>
Here you can accept the orders, manage items on portal and check the orders history.

And there it is. Feel free to test it for yourself!

## Used technology
Langagues:
* PHP
* JS
* SQL
* CSS
* HTML

Frameworks and other:
* JQuery 3.6.0
* Bootstrap 5.1.0

## Download
There's two ways: you can download the master branch with code, check how it's working and upload it on your hosting or try it with XAMPP, or simply download .zip with all needed files.

### Requirements
* Hosting with PHP 5.6 server or higher
* Prefered e-mail account on hosting
* MySQL server (or any other SQL server)

### Download link
[Here's](https://drive.google.com/file/d/1PoS2Blr0C-maADP216LYoyDIOXHSkaMc/view?usp=sharing) the download link for the latest version of the website in .zip file.

## Installation
Installation proces of the main features is very easy, but there's some steps that requires more attention.

**With version 1.0.0 new *database_structure.sql* file was uploaded. Remember to update it if you used previous one!**

### 1. Website files
Simply upload website files to your server or use it with XAMPP. It's the easiest part because all the files you need to run it are in project.

### 2. SQL Server
For the project I used this [MySQL Community Server](https://dev.mysql.com/downloads/mysql/) option. It's on GNU GPL licension so you can feel free to use it, but the MySQL server from XAMPP should do the work too. Choose what's best for you.

What you should do next is import database structure to your database server to create tables templates. In project files find *database_structure.sql* and integrate it with your database. Now you should have *rentit* database in your schemas.

Now you need to connect it with the website. Go to ***/php/connection.php*** in project path and change your connection data so the script will be able to work with database.

```php
  function getConnection(){
        $HOST = "localhost";    // <--- Change to database URL
        $USER = "root";         // <--- Change to database user
        $PASSWORD = "root";     // <--- Change to database password
        $DATABASE = "rentit";   // <--- Change to database name

        return mysqli_connect($HOST, $USER, $PASSWORD, $DATABASE);
    }
```

### 3. Mailing system
Last thing you need to handle is mailing system. If you have your own hosting you should be able to create your own e-mail address, it's the best way to make the website more professional. But if you're using XAMPP [here's](https://meetanshi.com/blog/send-mail-from-localhost-xampp-using-gmail/) a solution for you (which I used too!) to be able to send e-mails from XAMPP level. 

Whatever option you will choose you need to create e-mail which will be used to send messages from system. Of course if you use XAMPP you need also to complete little tutorial I wrote about in section above.

The last step of configuring it is to change few lines in ***/php/mail.php*** file. 
```php
  /// Change this if you want to configure mail system
    $admin_mail = "your-mail@gmail.com";    // <--- Change to e-mail address that should be used to send mails
    $website_url = "localhost/RentIt";      // <--- Change to your website 'home' location that users will be redirected with e-mail links
    $sender_host = "no-reply@gmail.com";    // <--- Change if you want to use no-reply function on your e-mail account or DELETE IT if you don't know how it works!
    /// ==========
```

**Congratulations! Now your rental portal should be good to go!**

## Changelog
What's new with the project? Here's the list:

* **1.0.0** --- 2021-09-18
    * INDEX PAGE:
        * added basic statistics
        * added 'best of' module
        * added favicon
    * OFFER:
        * added bar with statistics
        * small visual update
    * ADMIN:
        * added bar with statistics
        * added ability to add/delete categories and subcategories
        * added 'add new item' module
        * added history of orders with download option
        * added 'edit item' module
        * on 'upcoming/ending orders' module added colored bars
        * added information in case of no category for item
    * BUGS FIX:
        * multiple values in new order modal
        * minor bugs fix

* **0.1.0** --- 2021-09-10
    * code cleanup and docs writing
    * added banner to github

* **0.0.1** --- 2021-09-06
    * first functional version
    * items database system
    * ordering system
    * mailing system
    * now you can use it for yourself! ;)

## Thank you!
Thank you for peeking at my project!

If you're interested check out my other stuff [here](https://github.com/alehee)
