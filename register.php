<?php
require_once('Connections/login.php');

// 检查表单是否提交
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $username = $_POST['username'];
    $unam = $_POST['unam'];
    $banji = $_POST['banji'];
    
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
    $checkQuery1 = "SELECT * FROM user WHERE username='$username'";
    $checkQuery2 = "SELECT * FROM user WHERE unam='$unam'";
    $Result1 = mysql_query($checkQuery1, $login) or die(mysql_error());
    $Result2 = mysql_query($checkQuery2, $login) or die(mysql_error());
    if (mysql_num_rows($Result1) > 0) {
        echo '<script>alert("已有人使用该账户名，请更换一个号码");history.go(-1);</script>';
        exit;
    }
    else if(mysql_num_rows($Result2) > 0) {
        echo '<script>alert("名字已被占用请联系F8");history.go(-1);</script>';
        exit;
    }
    else{
        $insertQuery = "INSERT INTO user (username, password, unam, banji) VALUES ('$username','$password','$unam','$banji');"; 
        $Result = mysql_query($insertQuery, $login) or die(mysql_error());
        if ($Result) {
            $InsertQuery = "INSERT INTO student (姓名,班级) VALUES ('$unam','$banji') ;";
            $Result0 = mysql_query($InsertQuery, $login) or die(mysql_error());
            if ($Result0) {
                echo '<script>alert("用户注册成功");history.go(-1);</script>';
                header("Location: login.php");
                exit;
            }   else {
            echo '<script>alert("注册失败' . mysql_error() . '");history.go(-1);</script>';
                }
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
</head>

<body>
    <div class="header" id="head"><br/>学生成绩查询系统</div>

    <div class="container">
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <div class="tit2">注册</div>

            <input type="text" id="username" name="username"  placeholder="账号(请使用QQ号)"><br>
            
            <input type="password" id="password" name="password" placeholder="密码"><br>
            
            <input type="password" id="confirm_password" name="confirm_password" placeholder="确认密码"><br>

            <input type="text" id="banji" name="banji" placeholder="班级(格式1.2、1.5、2.8)"><br>

            <input type="text" id="unam" name="unam" placeholder="名字(请输入真实名称,错误则无法查询)">
            
            <button>注册</button>
            
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
