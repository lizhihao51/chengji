<?php
require_once('../../Connections/login.php');
require_once('../../Connections/is_login.php');
?>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="style/style.css" rel="stylesheet" type="text/css">
</head>
<body>
  <div id="box">
    <div class="xxi">
    <form action="s_admin_rank.php" method="post" enctype="multipart/form-data">
        <table width="660">
          <tr><td>密码</td><td><input class="xgk" type="password" id="paw" name="paw" placeholder="请输密码" value="<?php echo $row_stu_msg['学校']; ?>" required/></td></tr>
          <tr><td>确认密码</td><td><input class="xgk" type="password" id="paws" name="paws" placeholder="请输确认密码"  required/></td></tr>
          <tr><td></td><td><input type="submit" name="submit" class="submit" value="修改密码"/></td>
      </form>
    </div>
    <?php
    mysql_select_db($database_login, $login);
    $paw = $_POST['paw'];
    $unam = $_COOKIE["admin"];

    // 修改学生信息
    if ((isset($_POST["submit"])) && ($_POST["submit"] == "修改密码")) {
      $SQL = "UPDATE user SET password='$paw' WHERE unam='$unam'";
      $result = mysql_query($SQL);
      if ($result) {
        setcookie('admin',$unam , time()-3600,'/');
        echo"<script>alert(\"密码修改成功，请手动刷新\");history.go(-1);</script>";
      } else {
        echo "记录更新失败: " . mysql_error();
      }
    }
    ?>
  </div>
</body>
</html>
