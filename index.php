<?php require_once('Connections/login.php'); ?>
<?php session_start(); ?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="style/index.css" rel="stylesheet" type="text/css">
    <title>登录页面</title>
</head>

<body>
    <div id="bg">
        <div id="top">
            <a id="tuichu" href="Connections/exit.php">安全退出&nbsp;</a>
            <div class="tit">欢迎使用成绩管理系统</div>
        </div>
        <iframe id ="kuang" src="" width="100%" height="90%" scrolling="auto" frameborder="0">
        </iframe>
    </div>
</body>
</html>

<?php 
// 检查是否已经登录，如果登录了就判断权限
if (!isset($_COOKIE['admin'])) {
    echo "<script>window.location.href=\"login.php\";</script>";
} else {
    if (!isset($_SESSION['announcement_confirmed'])) {
        echo "<script>window.location.href=\"announcement.php\";</script>";
    } else {
        $cookee = $_COOKIE["admin"];
        $sql = "select power from user where unam='$cookee'";
        mysql_select_db("marks", $login);
        $result = mysql_query($sql, $login);
        $row = mysql_fetch_assoc($result);
        if ($row['power'] == '2') {
            // 如果是老师
            echo "<script>var link=document.getElementById(\"kuang\");</script>";
            echo "<script>link.src=\"Start/2.php\";</script>";
        } else {
            // 如果是学生
            echo "<script>var link=document.getElementById(\"kuang\");</script>";
            echo "<script>link.src=\"Start/student.php\";</script>";
        }
    }
}
?>