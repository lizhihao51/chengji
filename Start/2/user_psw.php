<?php
// 引入配置文件，假设该文件包含数据库连接信息
require_once('../../Connections/login.php'); 
require_once('../../Connections/is_login.php'); 

// 初始化变量
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_user = 20;
$pageNum_user = 0;
if (isset($_GET['pageNum_user'])) {
    $pageNum_user = $_GET['pageNum_user'];
}
$startRow_user = $pageNum_user * $maxRows_user;

// 获取搜索框的值
$searchUsername = isset($_GET['username'])? $_GET['username'] : '';
$searchUnam = isset($_GET['unam'])? $_GET['unam'] : '';

// 获取用户数据
mysql_select_db($database_login, $login);
// 构建 WHERE 子句
$whereClause = '1 = 1';
if (!empty($searchUsername)) {
    $whereClause.= " AND user.username LIKE '%". mysql_real_escape_string($searchUsername). "%'";
}
if (!empty($searchUnam)) {
    $whereClause.= " AND user.unam LIKE '%". mysql_real_escape_string($searchUnam). "%'";
}

// 构建 SQL 查询语句
$query_user = "SELECT * FROM user";
if ($whereClause!= '1 = 1') {
    $query_user.= " WHERE ". $whereClause;
}

// 先计算总记录数
$allResult = mysql_query($query_user, $login);
if (!$allResult) {
    die("总记录数查询失败: ". mysql_error());
}
$totalRows_user = mysql_num_rows($allResult);
$totalPages_user = ceil($totalRows_user / $maxRows_user);

// 再添加 LIMIT 子句进行分页查询
$query_limit_user = $query_user. " LIMIT ". $startRow_user. ", ". $maxRows_user;

// 执行分页查询
$result = mysql_query($query_limit_user, $login);
if (!$result) {
    die("查询失败: ". mysql_error());
}
// 构建查询字符串，用于分页链接
$queryString_user = '';
if (!empty($_GET)) {
    $param_pairs = [];
    foreach ($_GET as $key => $value) {
        // 确保所有参数都包含在分页链接中
        $param_pairs[] = urlencode($key). '='. urlencode($value);
    }
    if (!empty($param_pairs)) {
        $queryString_user = '?'. implode('&', $param_pairs);
    }
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员默认页</title>
<link href="style/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="box">
    <div class="search">
        <form id="user_search" name="user_search" method="get" action="user_psw.php">
            <p>
                账号：<input type="text" name="username" value="<?php echo htmlspecialchars($searchUsername);?>">
                姓名：<input type="text" name="unam" value="<?php echo htmlspecialchars($searchUnam);?>">
                <input type="submit" value="搜索">
            </p>
        </form>
        <div id="title3" class="title3">
            <ul>
                <li id="user">用户名</li>
                <li id="psw">密码</li>
                <li>名称</li>
                <li>班级</li>
                <li>级别</li>
                <li>班成绩</li>
                <li>级成绩</li>
                <li>超管</li>
                <li>操作</li>
            </ul>
        </div>
    </div> 
    <div id="jishu">
        共有 <?php echo $totalRows_user ;?> 条记录，目前显示第 <?php echo ($startRow_user + 1);?> 条至第 <?php echo min($startRow_user + $maxRows_user, $totalRows_user);?> 条
    </div>
    <?php if ($totalRows_user == 0) :?>
        <div class="list2" style="text-align:center;">目前还没有添加任何信息</div>
    <?php else :?>
        <?php while ($row_user = mysql_fetch_assoc($result)) :?>
            <div class="list1">
                <ul>
                <li id="user"><?php echo empty($row_user['username'])? '-' : $row_user['username'];?></li>
                <li id="psw"><?php echo empty($row_user['password'])? '-' : $row_user['password'];?></li>
                <li><?php echo empty($row_user['unam'])? '-' : $row_user['unam'];?></li>
                <li><?php echo empty($row_user['banji'])? '-' : $row_user['banji'];?></li>
                <li><?php echo empty($row_user['level'])? '-' : $row_user['level'];?></li>
                <li><?php echo empty($row_user['fun1'])? '-' : $row_user['fun1'];?></li>
                <li><?php echo empty($row_user['fun2'])? '-' : $row_user['fun2'];?></li>
                <li><?php echo empty($row_user['power'])? '-' : $row_user['power'];?></li>
                <li><a href="edit_user.php?id=<?php echo urlencode($row_user['id']);?>">修改</a></li>
                </ul>
            </div>
        <?php endwhile;?>
    <?php endif;?>
    <div id="menu">
        <?php if ($pageNum_user > 0 || $pageNum_user < $totalPages_user ) :?>
            <div id="xzys">
        <?php endif;?>
        <?php if ($pageNum_user > 0) :?>
            <a href="<?php printf("%s?pageNum_user=%d%s", $currentPage,  0, $queryString_user);?>"><img src="imgs/1.png" width="50px" height="50px"></a> 
        <?php else :?>
            <a><img src="imgs/w.png" width="50px" height="0px"></a>
        <?php endif;?>
        <?php if ($pageNum_user > 0) :?>
            <a href="<?php printf("%s?pageNum_user=%d%s", $currentPage,  max(0, $pageNum_user - 1), $queryString_user);?>"><img src="imgs/2.png" width="50px" height="50px"></a> 
        <?php else :?>
            <a><img src="imgs/w.png" width="50px" height="0px"></a>
        <?php endif;?>
        <?php if ($pageNum_user < $totalPages_user) :?>
            <a href="<?php printf("%s?pageNum_user=%d%s", $currentPage, min($totalPages_user, $pageNum_user + 1), $queryString_user);?>"><img src="imgs/3.png" width="50px" height="50px"></a> 
        <?php else :?>
            <a><img src="imgs/w.png" width="50px" height="0px"></a>
        <?php endif;?>
        <?php if ($pageNum_user < $totalPages_user) :?>
            <a href="<?php printf("%s?pageNum_user=%d%s",  $currentPage, $totalPages_user, $queryString_user);?>"><img src="imgs/4.png" width="50px" height="50px"></a> 
        <?php else :?>
            <a><img src="imgs/w.png" width="50px" height="0px"></a>
        <?php endif;?>
        </div>
    </div>
</div>
</body>
</html>