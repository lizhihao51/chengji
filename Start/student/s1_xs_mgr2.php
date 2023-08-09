<?php
require_once('../../Connections/login.php');
require_once('../../Connections/is_login.php');

// 确保输入框显示原内容
$unam = $_GET['unam'];
mysql_select_db($database_login, $login);
$query_stu_msg = "SELECT * FROM student WHERE 姓名='$unam'";
$stu_msg = mysql_query($query_stu_msg, $login) or die(mysql_error());
$row_stu_msg = mysql_fetch_assoc($stu_msg);

// HTML部分
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
      <form action="s1_xs_mgr2.php" method="post" enctype="multipart/form-data">
        <table width="660">
          <tr>
            <td>学校：</td>
            <td>
              <input class="xgk" type="text" id="xx" name="xx" placeholder="请输入学校" value="<?php echo $row_stu_msg['学校']; ?>" required/>
            </td>
          </tr>
          <tr>
            <td>班级：</td>
            <td>
              <input class="xgk" type="text" id="zym" name="zym" placeholder="请输入班级" value="<?php echo $row_stu_msg['班级']; ?>" required/>
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
                <option value="史 化 政">史 化 政</option>
                <option value="史 化 地">史 化 地</option>
                <option value="史 生 政">史 生 政</option>
                <option value="史 生 地">史 生 地</option>
                <option value="史 政 地">史 政 地</option>
              </select>
            </td>
          </tr>
          <tr>
            <td >姓名：</td>
            <td>
              <input class="xgk" type="text" id="xm" name="xm" placeholder="请输入姓名" value="<?php echo $row_stu_msg['姓名']; ?>" required/>
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
            <td><input type="submit" name="submit" class="submit" value="确认修改"/></td>
          </tr>
        </table>
      </form>
    </div>
    <?php
    mysql_select_db($database_login, $login);
    $xm = $_POST['xm'];
    $sex = $_POST["sex"];
    $banb = $_POST["banb"];
    $zym = $_POST["zym"];
    $note = $_POST["note"];
    $xx = $_POST["xx"];
    $unam = $_COOKIE["admin"];

    // 修改学生信息
    if ((isset($_POST["submit"])) && ($_POST["submit"] == "确认修改")) {
      $SQL = "UPDATE student SET 姓名='$xm', 性别='$sex', 班级='$zym',班别='$banb',备注='$note', 学校='$xx' WHERE 姓名='$unam'";
      $result = mysql_query($SQL);
      if ($result) {
        echo"<script>alert(\"记录更新成功\");</script>";
        header("Location:t_xs_detail.php");
      } else {
        echo "记录更新失败: " . mysql_error();
      }
    }
    ?>
  </div>
</body>
</html>
