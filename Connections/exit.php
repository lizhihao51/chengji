<?php
header("Content-Type:text/html;charset=utf-8");
//删除cookies
setcookie("admin","",time()-3600,'/');

echo"<script>alert(\"您已退出\");url=\"../login.php\";window.location.href=url;</script>";
?>
