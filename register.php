<?php
require_once('Connections/login.php');
header("Content-Type:text/html;charset=utf-8");
// 检查表单是否提交
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $username = $_POST['username'];
    $unam = $_POST['unam'];
    $cls=$_POST['baj'];
    $grade=$_POST['nij'];
    $Class = $grade . '.' . $cls;

    switch ($grade) {  // 开始 switch 语句，检查 $a 的值
        case 1:    // 如果 $a 等于 1：
            $level = 2025;  // 给变量 $b 赋值 2025
            break;      // 退出 switch 语句，避免继续执行其他的 case
        case 2:    // 如果 $a 等于 2：
            $level = 2024;  // 给变量 $b 赋值 2024
            break;      // 退出 switch 语句
        case 3:
            $level = 2023;
            break;
    }    
    
    // 进行数据验证
    if ($password !== $confirmPassword) {
        echo '<script>alert("密码和确认密码不匹配");history.go(-1);</script>';
        exit;
    } 
    else if (empty($username) || empty($password)) {
        echo '<script>alert("账号或密码不能留空");history.go(-1);</script>';
        exit;
    }
    
    mysql_select_db($database_login, $login); // 连接数据库
    
    // 检查用户名是否已存在
    $checkUN = "SELECT * FROM user WHERE username='$username'";
    $checkunam = "SELECT * FROM user WHERE unam='$unam'";
    $ResultA1 = mysql_query($checkUN, $login) or die(mysql_error());
    $ResultA2 = mysql_query($checkunam, $login) or die(mysql_error());
    if (mysql_num_rows($ResultA1) > 0) {
        echo '<script>alert("已有人使用该账户名，请更换一个号码");history.go(-1);</script>';
        $jy = 1;
        exit;
    }
    else if(mysql_num_rows($ResultA2) > 0) {
        echo '<script>alert("名字已被占用请联系F8");history.go(-1);</script>';
        $jy = 1;
        exit;
    }
    else if($jy != 1) {
        $insertQuery0 = "INSERT INTO user (username, password, unam, banji, level ) VALUES ('$username','$password','$unam','$Class','$level');"; 
        $Result2 = mysql_query($insertQuery0, $login) or die(mysql_error());
        if ($Result2) {
            $InsertQuery1 = "INSERT INTO student (姓名,班级,level) VALUES ('$unam','$Class','$level') ;";
            $Result3 = mysql_query($InsertQuery1, $login);
            if ($Result3) {
                echo '<script>alert("用户注册成功");window.location.href = "../login.php";</script>';
                exit;
            }
        } else {
            echo '<script>alert("注册失败' . mysql_error() . '");history.go(-1);</script>';
        }
    }      
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>注册页面</title>
    <link href="style/register.css" rel="stylesheet" type="text/css">
    <script src="Connections/class.js"></script>
</head>

<body>
    <div class="header" id="head"><br/>学生成绩查询系统</div>

    <div class="container">
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <div class="tit2">注册</div>

            <input type="text" id="username" name="username"  class="hx" placeholder="账号(请使用QQ号)"><br>
            
            <input type="password" id="password" name="password" class="hx" placeholder="密码"><br>
            
            <input type="password" id="confirm_password" name="confirm_password" class="hx" placeholder="确认密码"><br>
            <div class="bj1">年级：
                    <select onchange="test1()" id="nj" name="nij">
                        <option value="0">请选择</option>
                        <option value="1">高一</option>
                        <option value="2">高二</option>
                        <option value="3">高三</option>
                    </select>班级：<select id="bj" name="baj"></select>
            </div>
            
            <input type="text" id="unam" name="unam" class="hx" placeholder="名字(请输入真实名称,错误则无法查询)">
            
            <input type="submit" name="submit" class="submit" id="submit"value="注册"/>
            
        </form>
    </div>
    
    <div class="square">
        <ul>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>  
    </div>
    <div class="circle">
        <ul>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>

    <div id="foot">
    <br>
    Copyright © 2023 F8 Lisir™，All Rights Reserved.
    <br>
    联系邮箱：F8-lisir@foxmail.com
</div>
</body>
</html>
