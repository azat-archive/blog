Simple blog using symfony 2.0 DEV
========================

What's inside?
--------------
Simple blog symfony bundle, with posts, comments, users

What Symfony2 components used:
--------------
* Dotrine ORM
* Entity
* Form (Assert)
* Controller
* View
* Template helper
* Twig extension
* User interface via SecurityBundle

External bundles:
--------------
* PaginatorBundle - https://github.com/knplabs/PaginatorBundle
* MenuBundle - https://github.com/knplabs/MenuBundle

Configuration
-------------

For apache

	<VirtualHost 127.0.0.1:80>
		Options +FollowSymLinks
		# uncomment for develop mode
		# SetEnv APPLICATION_ENV "development"

		ServerName blog
		DocumentRoot "/var/www/blog/web"
	</VirtualHost>
