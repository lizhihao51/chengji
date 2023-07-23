<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_login = "localhost";
$database_login = "marks";
$username_login = "root";
$password_login = "root";
$login = mysql_connect($hostname_login, $username_login, $password_login) or trigger_error(mysql_error(),E_USER_ERROR); 


?>
