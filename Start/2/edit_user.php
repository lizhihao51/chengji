<?php
// 引入配置文件，假设该文件包含数据库连接信息
require_once('../../Connections/login.php'); 
require_once('../../Connections/is_login.php'); 

if (isset($_GET['id'])) {
    $id = mysql_real_escape_string($_GET['id']);
    // 获取用户数据
    mysql_select_db($database_login, $login);
    $query = "SELECT * FROM user WHERE id = '$id'";
    $result = mysql_query($query, $login);
    if (!$result) {
        die("查询失败: ". mysql_error());
    }
    $user = mysql_fetch_assoc($result);
} else {
    die("无效的请求");
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改用户信息</title>
<link href="style/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="box">
    <form id="edit_user_form" name="edit_user_form" method="post" action="update_user.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']);?>">
        <p>
            ID：<input type="text" name="username" value="<?php echo htmlspecialchars($user['username']);?>"><br>
            密码：<input type="text" name="password" value="<?php echo htmlspecialchars($user['password']);?>"><br>
            名称：<input type="text" name="unam" value="<?php echo htmlspecialchars($user['unam']);?>"><br>
            班级：<input type="text" name="banji" value="<?php echo htmlspecialchars($user['banji']);?>"><br>
            级别：<input type="text" name="level" value="<?php echo htmlspecialchars($user['level']);?>"><br>
            权限：<input type="text" name="power" value="<?php echo htmlspecialchars($user['power']);?>"><br>
            功能 1：<input type="text" name="fun1" value="<?php echo htmlspecialchars($user['fun1']);?>"><br>
            功能 2：<input type="text" name="fun2" value="<?php echo htmlspecialchars($user['fun2']);?>"><br>
            <input type="submit" value="保存修改">
        </p>
    </form>
</div>
</body>
</html>