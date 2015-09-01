# phalcon.angular.bootstrap
Biolerplate for a non single page implementation of Angular, Phalcon, and Bootstrap.  Has a user creation, activation email (using SendGrid), user login to a secure page, and role management to an admin page

Requirements:
Phalcon www.phalconphp.com

Composer www.getcomposer.com

SendGrid account www.sendgrid.com
(username/password set in app/models/User.php -> sendActivationEmail())

bootstrap.sql is a basic database with users and roles tables

mod_rewrite must be enabled on the server

Implementation can be seen at http://104.131.144.103:8080/
