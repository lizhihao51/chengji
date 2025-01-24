<?php
// 引入配置文件，假设该文件包含数据库连接信息
require_once('../../Connections/login.php');
require_once('../../Connections/is_login.php');

// 确保输入框显示原内容
$unam = $_GET['unam'];
$le = $_GET['level'];
mysql_select_db($database_login, $login);
$query_stu_msg = "SELECT * FROM student WHERE XM='$unam' and level='$le'";
$stu_msg = mysql_query($query_stu_msg, $login) or die(mysql_error());
$row_stu_msg = mysql_fetch_assoc($stu_msg);

// 将学生信息存储在会话中，以便在 HTML 文件中使用
session_start();
$_SESSION['row_stu_msg'] = $row_stu_msg;
$_SESSION['le'] = $le;
$_SESSION['unam'] = $unam;
?>