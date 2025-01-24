<!--学生信息页-->
<?php require_once('../../Connections/login.php'); ?>
<?php require_once('../../Connections/is_login.php'); ?>

<?php
$unam=$_COOKIE["admin"];
$level=$_COOKIE["level"];
mysql_select_db($database_login, $login);
$query_stu_msg = "SELECT * FROM student WHERE XM='$unam'and level='$level'";

$stu_msg = mysql_query($query_stu_msg, $login) or die(mysql_error());
$row_stu_msg = mysql_fetch_assoc($stu_msg);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>个人信息页</title>
<link href="style/style.css" rel="stylesheet" type="text/css">
<link href="style/ico.css" rel="stylesheet" type="text/css">

</head>

<body>
<div id="box">
<div class="xxi">
<table width="660">
    <tr>
        <td>学校：</td>
        <td><?php echo $row_stu_msg['XX']; ?></td>
      </tr>
    <tr>
        <td>届别：</td>
        <td><?php echo $row_stu_msg['level']; ?> 届</td>
        </tr>
    <tr>
        <td>班级：</td>
        <td><?php echo $row_stu_msg['BJ']; ?></td>
        </tr>
    <tr>
        <td>班别：</td>
        <td><?php echo $row_stu_msg['BB']; ?></td>
      </tr>
        <td width="100">姓名：</td>
        <td width="460"><?php echo $row_stu_msg['XM']; ?></td>
      </tr>
    <tr>
        <td>性别：</td>
        <td><?php echo $row_stu_msg['XB']; ?></td>
      </tr>
    <tr>
        <td>备注：</td>
        <td><?php echo $row_stu_msg['BZ']; ?></td>
      </tr>
    
</table>
<button class="submit" onclick="tiao()">修改信息</button>
<form action="my_detail.php" method="post" hidden="">
    <input type="text" id="unam" name="unam" required />
</form>
</div>
</div>


</body>
</html>
<script>
function tiao(){
	var url="edit_student.php?unam=<?php echo "$unam";?>&id=<?php echo $row_stu_msg['id'];?>&level=<?php echo $row_stu_msg['level'];?>";
	window.location.href=url;
} 
</script>
