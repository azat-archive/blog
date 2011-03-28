Simple blog using symfony 2.0 DEV
========================

What's inside?
--------------

Configuration
--------------

	For apache

	<VirtualHost 127.0.0.1:80>
		Options +FollowSymLinks
		# uncomment for develop mode
		# SetEnv APPLICATION_ENV "development"

		ServerName blog
		DocumentRoot "/var/www/blog/web"
	</VirtualHost>
