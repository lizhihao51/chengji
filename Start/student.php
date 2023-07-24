<!--学生侧边栏-->
<?php require_once('../Connections/is_login.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>学生管理界面</title>
<link href="style/student.css" rel="stylesheet" type="text/css">

</head>

<body>
<div id="box">
  <div id="left">
  <div class="anniu">
  	<a href="student/t_xs_detail.php" target="kuang">个人信息</a>
  </div>

  <div class="anniu">
  	<a href="student/s_my_msg.php" target="kuang">我的成绩</a>
  </div>

  <div class="anniu">
    <a href="student/jiagong.php" target="kuang">各科成绩</a>
  	<!--<a href="student/s_all_rank.php" target="kuang">各科成绩</a>-->
  </div>
  
  </div>
  <div id="right">
    
    <div id="main-title">
    </div>
    
    <div id="main-bg">
    	<iframe id="kuang" src="student/t_xs_detail.php" scrolling="auto" name="kuang">
        </iframe>
      
      

    </div>
  </div>
</div>




</body>
</html>