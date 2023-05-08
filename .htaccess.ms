RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^([^\.]+)$ $1.php [NC,L]
#
#
#
#
#https://alexcican.com/post/how-to-remove-php-html-htm-extensions-with-htaccess/
#
#
#
Redirect 301 http://www.expertanswer.org https://www.expertanswer.org
#
Redirect 301 http://expertanswer.org https://expertanswer.org
#
#php_value upload_max_filesize 20M
#php_value post_max_size 20M
#php_value max_input_time 2400






