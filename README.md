<div align="center">
    <a href="https://php.net">
        <img
            alt="PHP"
            src="https://www.php.net/images/logos/new-php-logo.svg"
            width="150">
    </a>
</div>

# REAL ESTATE MANAGEMENT SYSTEM
Real estate systems are becoming increasingly popular in today's world, as they provide an efficient and convenient way to manage property. The real estate system we are discussing in this report is built using HTML, CSS, JavaScript, AJAX, jQuery, PHP, and MySQL technologies. This system aims to make property management more accessible, faster, and more efficient. We designed this System for Realtors Inc.


## Prerequisites
To run this project on a Windows machine, you will need the following software installed:

- XAMPP or a similar web server bundle that includes Apache, PHP, and MySQL
- A web browser, such as Chrome or Firefox

- Web Server: You will need a web server that supports PHP, such as Apache, Nginx, or Microsoft IIS. These servers can be installed on your local machine or on a remote server.
- PHP: PHP is a programming language that is used to create dynamic web pages. You will need a version of PHP installed on your server or local machine. The minimum version of PHP required for your project will depend on the specific requirements of your project.
- MySQL: MySQL is a database management system that is used to store and retrieve data for your project. You will need to have a MySQL server installed on your machine or hosted on a remote server.
- Database Management Tool: You will need a tool to manage your MySQL database. Popular options include phpMyAdmin, MySQL Workbench, and HeidiSQL.
- Text Editor: You will need a text editor to write and edit your PHP code. Popular options include Sublime Text, Atom, and Visual Studio Code.

Browser: You will need a web browser to test and view your PHP web pages. Popular options include Chrome, Firefox, and Safari.

## Installation
- Download the project files and extract them to the htdocs directory of your XAMPP installation. The htdocs directory is typically located at C:\xampp\htdocs.
- Open XAMPP and start the Apache and MySQL services.
- Open a web browser and navigate to http://localhost/phpmyadmin/.
- In http://localhost/real-estate-listing/config/credentials.php, edit the database name with a name of your choice using a code editor like VSCode.
- Open a web browser and navigate to http://localhost/real-estate-listing/. This will automatically create an empty database and connect to that database.

## Usage
- Navigate to http://localhost/real-estate-listing/auth/manager-register.php to create a new account for the property manager
- Navigate to http://localhost/real-estate-listing/auth/admin-register.php to create a new account for the admin account, if successful this will automatically to the admin login page.
- Login into the admin dashboard
- Create Locations for your properties
- Create Property types for your properties
- Create a New Property and assign it to one of the property mangers you created above
- Create more properties
- Navigate to http://localhost/real-estate-listing/auth/user-register.php to create a new account for the user, if successful this will automatically to the user login page.
- Login in as a User, this will automatically take you to the properties listing page
- You can search for properties by name, location or both
- Click on any property to navigate to the property profile page
- Schedule a Visit with the property manager to visit this property from it's profile page
- You can view your scheduled visits from http://localhost/real-estate-listing/scheduled-visits.php , and you can sort the by status PENDING, REJECTED, CANCELLED or COMPLETED
- User can cancel a visit
- Login to manager dashboard http://localhost/real-estate-listing/auth/manager-login.php 
- As a manager, you can only view properties assigned to you as a manager by the platform administrator
- You can search for properties by name, location or both
- As a manager, you can reject a visit from a user 
- As a manger, you can mark a visit as successful/completed , once the visit has completed you can mark house as SOLD


## Contributing to Real Estate Listing Project

We welcome contributions to our project from anyone! Here are some guidelines for contributing:

## Reporting Issues
If you find a bug or have a suggestion for a new feature, please report it on our GitHub Issues page. When reporting an issue, please provide as much detail as possible, including steps to reproduce the issue and any error messages you received.

## Contributing Code
If you would like to contribute code to the project, follow these steps:

- Fork the project repository to your own GitHub account.
- Clone the repository to your local machine.
- Create a new branch for your changes.
- Make your changes and test them locally.
- Commit your changes with a clear commit message.
- Push your changes to your forked repository.
- Submit a pull request to the original repository.
- Your pull request will be reviewed by our team, and we may ask you to make additional changes before it can be merged.

## Contributors
- Edgar Tinkamanyire - https://github.com/edgar256

## Code of Conduct
When contributing to this project, please adhere to our Code of Conduct. We expect all contributors to follow our code of conduct, which outlines our expectations for respectful behavior and our process for addressing conflicts.

## License
[Insert the license under which the project is released]