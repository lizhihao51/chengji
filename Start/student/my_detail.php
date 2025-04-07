<?php
session_start();
require_once('../../Connections/login.php');
require_once('../../Connections/is_login.php');

// 防止 SQL 注入
$unam = mysql_real_escape_string($_COOKIE["admin"]);
$level = mysql_real_escape_string($_COOKIE["level"]);

mysql_select_db($database_login, $login);
$query_stu_msg = "SELECT * FROM student WHERE XM='$unam' AND level='$level'";
$stu_msg = mysql_query($query_stu_msg, $login);

if (!$stu_msg) {
    // 记录日志或显示通用错误信息
    echo "数据库查询出错，请稍后再试。";
    exit;
}

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
                <td><?php echo isset($row_stu_msg['XX']) ? $row_stu_msg['XX'] : ''; ?></td>
            </tr>
            <tr>
                <td>届别：</td>
                <td><?php echo isset($row_stu_msg['level']) ? $row_stu_msg['level'] : ''; ?> 届</td>
            </tr>
            <tr>
                <td>班级：</td>
                <td><?php echo isset($row_stu_msg['BJ']) ? $row_stu_msg['BJ'] : ''; ?></td>
            </tr>
            <tr>
                <td>班别：</td>
                <td><?php echo isset($row_stu_msg['BB']) ? $row_stu_msg['BB'] : ''; ?></td>
            </tr>
            <tr>
                <td width="100">姓名：</td>
                <td width="460"><?php echo isset($row_stu_msg['XM']) ? $row_stu_msg['XM'] : ''; ?></td>
            </tr>
            <tr>
                <td>性别：</td>
                <td><?php echo isset($row_stu_msg['XB']) ? $row_stu_msg['XB'] : ''; ?></td>
            </tr>
            <tr>
                <td>备注：</td>
                <td><?php echo isset($row_stu_msg['BZ']) ? $row_stu_msg['BZ'] : ''; ?></td>
            </tr>
        </table>
        <button class="submit" onclick="tiao()">修改信息</button>
    </div>
</div>

<script>
function tiao() {
    var unam = "<?php echo $unam; ?>";
    var id = "<?php echo isset($row_stu_msg['id']) ? $row_stu_msg['id'] : ''; ?>";
    var level = "<?php echo isset($row_stu_msg['level']) ? $row_stu_msg['level'] : ''; ?>";
    var url = "edit_detail.php?unam=" + encodeURIComponent(unam) + "&id=" + encodeURIComponent(id) + "&level=" + encodeURIComponent(level);
    window.location.href = url;
}
</script>
</body>
</html>