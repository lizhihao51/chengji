<?php
session_start();
// 从会话中获取学生信息
$row_stu_msg = $_SESSION['row_stu_msg'];
$le = $_SESSION['le'];
$unam = $_SESSION['unam'];

// 引入配置文件，假设该文件包含数据库连接信息
require_once('../../Connections/login.php');
require_once('../../Connections/is_login.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sex = $_POST["sex"];
    $banb = $_POST["banb"];
    $zym = $_POST["zym"];
    $note = $_POST["note"];
    $xx = $_POST["xx"];

    // 修改学生信息
    if ((isset($_POST["submit"])) && ($_POST["submit"] == "保存修改")) {
        mysql_select_db($database_login, $login);
        $SQL1 = "UPDATE student SET XB='$sex', BJ='$zym',BB='$banb',BZ='$note', XX='$xx' WHERE XM = '$unam'and level = '$le'";
        $SQL2 = "UPDATE user SET banji='$zym' WHERE unam = '$unam'and level = '$le'";
        $result1 = mysql_query($SQL1);
        $result2 = mysql_query($SQL2);
        if ($result1 and $result2) {
            echo"<script>alert(\"记录更新成功\");url=\"my_detail.php\";window.location.href=url;</script>";
        } else {
            echo "记录更新失败: " . mysql_error();
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title></title>
  <link href="style/style.css" rel="stylesheet" type="text/css">
</head>
<body>
  <div id="box">
    <div class="xxi">
      <form action="edit_student.php" method="post" enctype="multipart/form-data">
        <table width="660">
          <tr><td>学校：</td>
            <td><input class="xgk" type="text" id="xx" name="xx" placeholder="请输入学校" value="<?php echo $row_stu_msg['XX']; ?>" required/></td>
          </tr>
          <tr><td>届别：</td>
            <td><input class="xgk" placeholder="<?php echo $row_stu_msg['level']; ?> 届" disabled/></td>
          </tr>
          <tr><td>班级：</td>
            <td>
              <input class="xgk" type="text" id="zym" name="zym" placeholder="请输入班级" value="<?php echo $row_stu_msg['BJ']; ?>" required/>
            </td>
          </tr>
          <tr>
            <td>班别：</td>
            <td>
            <select name="banb" id="banb">
                <option value="物 化 生">物 化 生</option>
                <option value="物 化 政">物 化 政</option>
                <option value="物 化 地">物 化 地</option>
                <option value="物 生 政">物 生 政</option>
                <option value="物 生 地">物 生 地</option>                
                <option value="史 化 地">史 化 地</option>
                <option value="史 政 地">史 政 地</option>
              </select>
            </td>
          </tr>
          <tr>
            <td width="100">姓名：</td>
            <td width="460">
              <input class="xgk" placeholder="<?php echo $row_stu_msg['XM']; ?>"disabled/>
            </td>
          </tr>
          <tr>
            <td>性别：</td>
            <td>
              <select name="sex" id="sex">
                <option value="男">男</option>
                <option value="女">女</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>备注：</td>
            <td>
              <input class="xgk" type="text" id="note" name="note" placeholder="请输入备注" value="<?php echo $row_stu_msg['备注']; ?>"/>
            </td>
          </tr>
          <tr>
            <td></td>
            <td><input type="submit" name="submit" value="保存修改"></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</body>
</html>