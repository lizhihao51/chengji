<?php require_once('login.php'); ?>
<?php
header("Content-Type:text/html;charset=utf-8");

	//error_reporting(0);//关闭所有报告错误
if(!isset($_COOKIE['admin'])){
	//没有cookie登录
	if(isset($_POST['username']) && isset($_POST['password'])){
		$uname=$_POST["username"];
		$password=$_POST["password"];
		$sql="select username,password,unam from user where username='$uname' and password='$password'";
		
		mysql_select_db($database_login, $login);
		$result = mysql_query($sql,$login); 
		$row = mysql_fetch_assoc($result);
		$cookie=$row["unam"];
		if ($uname == "" or $password == ""){
    echo '<script>alert("账号或密码不能留空");history.go(-1);</script>';
	}
	else if ($row) {
			setcookie("admin",$cookie,time()+3600,'/');
			echo"<script>url=\"../index.php\";window.location.href=url;</script>";
		} 
		else {
			echo"<script>alert(\"没有注册,或账号或密码错误\");</script>";
			echo"<script>url=\"../login.php\";window.location.href=url;</script>";
		}
		//echo "没有cookie登录<br>";
	}
}
else
{
//有cookies
	if(!isset($_POST['exit']))
		{
	//没有点退出
			$cookie = $_COOKIE['admin'];
			echo "cookie:",$cookie;
			echo"<script>url=\"../index.php\";window.location.href=url;</script>";
		}	
	else
		{
			//点了退出
		
				setcookie('admin', $row1['username'], time()-3600,'/');
				echo "<script>alert(\"已经退出\");</script>";
		}		
}
?>
<form id="user" name="user" method="POST" action="cookies.php">
	<p>
    	<input type="submit" name="exit" id="exit" value="退出"/>
	</p>
</form>