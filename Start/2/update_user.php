<?php
// 引入配置文件，假设该文件包含数据库连接信息
require_once('../../Connections/login.php'); 
require_once('../../Connections/is_login.php'); 

if (isset($_POST['id'])) {
    $id = mysql_real_escape_string($_POST['id']);
    $username = mysql_real_escape_string($_POST['username']);
    $password = mysql_real_escape_string($_POST['password']);
    $unam = mysql_real_escape_string($_POST['unam']);
    $banji = mysql_real_escape_string($_POST['banji']);
    $level = mysql_real_escape_string($_POST['level']);
    $power = mysql_real_escape_string($_POST['power']);
    $fun1 = mysql_real_escape_string($_POST['fun1']);
    $fun2 = mysql_real_escape_string($_POST['fun2']);

    // 更新用户数据
    mysql_select_db($database_login, $login);
    $query = "UPDATE user SET password = '$password', unam = '$unam', banji = '$banji', level = '$level', username = '$username', power = '$power', fun1 = '$fun1', fun2 = '$fun2' WHERE id = '$id'";
    $result = mysql_query($query, $login);
    if (!$result) {
        die("更新失败: ". mysql_error());
    } else {
        header("Location: user_psw.php");
    }
} else {
    die("无效的请求");
}
?>