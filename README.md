# RateMyCourses Documentation

## Installation

Clone this repository into a directory that you wish to run your site. In /lib/db-connect.php, change the username, password, 
and host to accommodate your SQL server. The user you use for this application must have access to the following commands in this database:

* CREATE TABLE
* SELECT
* INSERT
* UPDATE

After that, create a Virtual Host that points to the ratemycourses directory of the cloned repository. Once the Virtual Host is set up and
running, navigating to the virtual host name will bring you to the main page of the website.

## Structure

The structure of the application is as follows:
index.php in the top-level directory is the home page for the application. When the virtual host points to the ratemycourses git directory,
this is the page that automatically loads.

majors-page.php is the page that loads the majors and courses for each school once a school is selected from index.php

admin-panel.php is the page that contains all of the admin and moderator actions. These actions redirect to the index.php pages in the
createcourse, createschool, and createmajor folders.

When a user selects a course from majors-page.php, they are directed to the index.php page in the viewcourse folder.
If the user wants to rate this course, they are directed to the index.php page in the createcomment folder.

If a user wants to submit a suggestion, they are directed to index.php in the suggest folder.

Search results are displayed in the index.php page in the search folder.

All php helper functions to load data from the database are located in the various files in the lib folder. The lib folder also contains 
the connection and installation scripts for the database, the logout script, and all php scripts that recieve a POST request when 
information is submitted.

The resources folder contains all of the images that are displayed for each rating, all CSS files, all Javascript files, and the php file
for the navbar that is included in all pages.

## Testing the Application
In order to test this application, import the ratemycourses.sql file into phpMyAdmin. This will import a database with testing data. 
Feel free to create an account to test the functionality for being logged in.
In order to test admin functionality, the database has an existing admin account. The credentials for this admin account are:
username: Admin
password: Salt1


