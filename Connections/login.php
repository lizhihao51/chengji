<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

function getDatabaseConnection() {
    $hostname = "localhost";
    $database = "marks";
    $username = "root";
    $password = "15829931165";
    $connection = mysql_connect($hostname, $username, $password) or trigger_error(mysql_error(), E_USER_ERROR);
    mysql_select_db($database, $connection);
    return $connection;
}

$login = getDatabaseConnection();
?>