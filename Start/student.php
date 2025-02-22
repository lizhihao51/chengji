<!--学生侧边栏-->
<?php $unam=$_COOKIE["admin"];
$level=$_COOKIE["level"];
$fun=$_COOKIE["fun"];
?>
<?php require_once('../Connections/is_login.php'); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>学生管理界面</title>
<link href="style/student.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="box">

  <div id="left">
    <br>
    <div class="xzk">
      <a href="student/my_detail.php" target="kuang">个人信息</a>
    </div>

    <div class="xzk">
      <a href="student/cj.php" target="kuang">我的成绩</a>
    </div>
  <?php
    // 检查 status 的值，并显示对应的内容
    if ($fun === '110') {
        // 显示 a 界面
        echo '<div class="xzk">
                <a href="student/s_bj_rank.php" target="kuang">班成绩单</a>
              </div>';
    } elseif ($fun === '100') {
        // 显示 b 界面
        echo '<div class="xzk">
                <a href="student/s_bj_rank.php" target="kuang">班成绩单</a>
              </div>';
    } else {
        // 默认显示内容
        echo '<div class="xzk">
                <a href="student/s_bj_rank.php" target="kuang">班成绩单</a>
              </div>';
    }
  ?>

  <?php
    // 检查 status 的值，并显示对应的内容
    if ($fun === '110') {
        // 显示 a 界面
        echo '<div class="xzk">
                <a href="student/s_all_rank.php" target="kuang">级成绩单</a>
              </div>';
    } elseif ($fun === '010') {
        // 显示 b 界面
        echo '<div class="xzk">
                <a href="student/s_all_rank.php" target="kuang">级成绩单</a>
              </div>';
    } else {
        // 默认显示内容
        echo '<div class="xzk">
                <a href="student/s_all_rank.php" target="kuang">级成绩单</a>
              </div>';
    }
  ?>
    <div class="xzk">
      <a href="student/my_cj.php" target="kuang">各科成绩</a>
    </div>
    <div class="xzk">
      <a href="student/s_admin_rank.php?unam=<?php echo "$unam";?>" target="kuang">修改密码</a>
    </div>

</div>
  
  <div id="right">
    <div id="main-bg">
      <iframe id="kuang" src="student/my_detail.php" scrolling="auto" name="kuang">
        </iframe>
    </div>
  </div>
</div>




</body>
</html>