<!--学生侧边栏-->
<?php $unam=$_COOKIE["admin"];
$fun=$_COOKIE["fun"];
?>
<?php require_once('../Connections/is_login.php'); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>超级管理员</title>
<link href="style/student.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="box">

  <div id="left">
    <br>
    <!-- <div class="xzk">
      <a href="2/t_xs_detail.php" target="kuang">个人信息</a>
    </div> -->

    <!-- <div class="xzk">
      <a href="2/s_my_msg.php" target="kuang">我的成绩</a>
    </div> -->
  <?php
    // 检查 status 的值，并显示对应的内容
    if ($fun === '110') {
        // 显示 a 界面
        echo '<div class="xzk">
                <a href="2/bj_rank.php" target="kuang">班成绩单</a>
              </div>';
    } elseif ($fun === '100') {
        // 显示 b 界面
        echo '<div class="xzk">
                <a href="2/bj_rank.php" target="kuang">班成绩单</a>
              </div>';
    } else {
        // 默认显示内容
        echo '<div class="xzk">
                <a href="2/bj_rank.php" target="kuang">班成绩单</a>
              </div>';
    }
  ?>

  <?php
    // 检查 status 的值，并显示对应的内容
    if ($fun === '110') {
        // 显示 a 界面
        echo '<div class="xzk">
                <a href="2/all_rank.php" target="kuang">级成绩单</a>
              </div>';
    } elseif ($fun === '010') {
        // 显示 b 界面
        echo '<div class="xzk">
                <a href="2/all_rank.php" target="kuang">级成绩单</a>
              </div>';
    } else {
        // 默认显示内容
        echo '<div class="xzk">
                <a href="2/all_rank.php" target="kuang">级成绩单</a>
              </div>';
    }
  ?>
    <div class="xzk">
      <a href="2/personal_score.php" target="kuang">个人成绩</a>
    </div>

    <div class="xzk">
      <a href="2/user_psw.php" target="kuang">用户密码</a>
    </div>

    <div class="xzk">
    <a href="2/403.php" target="kuang">修改学年</a>
    </div>

    <div class="xzk">
    <a href="2/user_rank.php" target="kuang">详细成绩</a>
    </div>

    <div class="xzk">
      <a href="2/s_admin_rank.php?unam=<?php echo "$unam";?>" target="kuang">修改密码</a>
    </div>

</div>
  
  <div id="right">
    <div id="main-bg">
      <iframe id="kuang" src="2/default.php" scrolling="auto" name="kuang">
        </iframe>
    </div>
  </div>
</div>




</body>
</html>