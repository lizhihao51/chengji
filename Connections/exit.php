<?php
header("Content-Type:text/html;charset=utf-8");
// 删除cookies
setcookie("admin", "", time() - 3600, '/');
setcookie("level", "", time() - 3600, '/');
setcookie("fun", "", time() - 3600, '/');

// 清除会话变量
session_start();
unset($_SESSION['announcement_confirmed']);

echo "<script>alert(\"您已退出\");url=\"../login.php\";window.location.href=url;</script>";
?>