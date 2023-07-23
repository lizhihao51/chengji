<?php
if(isset($_COOKIE['admin'])){
	echo "<script>window.location.href=\"index.php\";</script>";
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>成绩管理系统</title>
<link href="style/style.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="header" id="head"><br/>学生成绩查询系统</div>

    <div class="container">
        <form id="user" name="user" method="POST" action="Connections/cookies.php">
            
            <div class="tit">登录</div>

        <input type="text" name="username" id="username" placeholder="账号">
        
        <input type="password" name="password" id="password" placeholder="密码">

        <button>登录</button>

        <span><br>没有账号？<a href="register.php">去注册</a></br></span>
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