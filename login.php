<?php
if(isset($_COOKIE['admin'])){
	echo "<script>window.location.href=\"index.php\";</script>";
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>成绩管理系统</title>
<link href="style/style.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="header" id="head"><br/>学生成绩查询系统</div>
    <div id="gonggao">
        <br/>公告：</br>
        高三级一模考试成绩已经更新（历史类除外），化/生/政/地小四门科目会出现两个成绩，前者为原始分后者为赋分后。排名会出现三个以此为 班排名/校排名/县排名</br>
        <br>
    </div>
    <script>
        // 页面加载时触发输入确认
        window.onload = function() {
            // 弹出输入框，要求用户输入确认信息
            alert("一模已经更新（历史类除外）\n化/生/政/地两个成绩，前为原始后为赋分。\n排名会三个以此为 班排名/校排名/县排名。");
        };
        
    </script>

    <div class="container">
        <form id="user" name="user" method="POST" action="Connections/cookies.php">
            
            <div class="tit" >登录</div >

        <input type="text" name="username" id="username" placeholder="账号">
        
        <input type="password" name="password" id="password" placeholder="密码">

        <button >登录</button>
        <!-- <disabled> -->

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
联系邮箱：F8lisir@foxmail.com
</div>

</body>
</html>