<!--学生信息页-->
<?php require_once('../../Connections/login.php'); ?>
<?php require_once('../../Connections/is_login.php'); ?>

<?php
$unam=$_COOKIE["admin"];
mysql_select_db($database_login, $login);
$query_stu_msg = "SELECT * FROM student WHERE 姓名='$unam'";

$stu_msg = mysql_query($query_stu_msg, $login) or die(mysql_error());
$row_stu_msg = mysql_fetch_assoc($stu_msg);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>个人信息页</title>
<link href="style/style.css" rel="stylesheet" type="text/css">

</head>

<body>
<div id="box">
<div id="xxi">
<table width="660">
    <tr>
        <td>学校：</td>
        <td><?php echo $row_stu_msg['学校']; ?></td>
      </tr>
    <tr>
        <td>班级：</td>
        <td><?php echo $row_stu_msg['班级']; ?></td>
      </tr>
        <td width="105">姓名：</td>
        <td width="550"><?php echo $row_stu_msg['姓名']; ?></td>
      </tr>
    <tr>
        <td>性别：</td>
        <td><?php echo $row_stu_msg['性别']; ?></td>
      </tr>
    <tr>
        <td>备注：</td>
        <td><?php echo $row_stu_msg['备注']; ?></td>
      </tr>
    
</table>
<button onclick="tiao()">修改信息</button>
<form action="t_xs_detail.php" method="post" hidden="">
    <input type="text" id="unam" name="unam" required />
</form>
</div>

</body>
</html>
<script>
function tiao(){
	var url="s1_xs_mgr2.php?unam=<?php echo "$unam";?>";
	window.location.href=url;
} 
</script>
