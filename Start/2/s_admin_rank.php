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
          <tr><td>密码</td><td><input class="xgk" type="password" id="paw" name="paw" placeholder="请输密码"  required/></td></tr>
          <tr><td>确认密码</td><td><input class="xgk" type="password" id="paws" name="paws" placeholder="请输确认密码"  required/></td></tr>
          <tr><td></td><td><input type="submit" name="submit" class="submit" value="修改密码"/></td>
      </form>
    </div>
    <?php
    mysql_select_db($database_login, $login);
    $paw = isset($_POST['paw']) ? $_POST['paw'] : ''; // 如果 `paw` 存在则赋值，否则为空字符串
    $paws = isset($_POST['paws']) ? $_POST['paws'] : ''; // 如果 `paws` 存在则赋值，否则为空字符串
    $unam = isset($_COOKIE["admin"]) ? $_COOKIE["admin"] : ''; // 检查 `admin` cookie 是否存在
    
    // 修改学生信息
    if (isset($_POST["submit"]) && $_POST["submit"] == "修改密码") {
      // 判断 paw 和 paws 是否相等
      if ($paw === $paws && !empty($paw)) {
        $SQL = "UPDATE user SET password='$paw' WHERE unam='$unam'";
        $result = mysql_query($SQL);
    
        if ($result) {
          setcookie('admin', $unam, time() - 3600, '/');
          echo "<script>alert('密码修改成功，请手动刷新'); history.go(-1);</script>";
        } else {
          echo "记录更新失败: " . mysql_error();
        }
      } else {
        // 提示密码不一致的错误
        echo "<script>alert('两次输入的密码不一致，请重新输入');</script>";
      }
    }
    ?>
  </div>
</body>
</html>
