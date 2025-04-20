<?php
// 引入配置文件，假设该文件包含数据库连接信息
require_once('../../Connections/login.php'); 
require_once('../../Connections/is_login.php'); 
require_once('../../Connections/pagination.php');

// 初始化变量
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_cj_rank = 20;
$pageNum_cj_rank = 0;
if (isset($_GET['pageNum_cj_rank'])) {
    $pageNum_cj_rank = $_GET['pageNum_cj_rank'];
}
$startRow_cj_rank = $pageNum_cj_rank * $maxRows_cj_rank;

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
$query_cj_rank = "SELECT * FROM user";
if ($whereClause!= '1 = 1') {
    $query_cj_rank.= " WHERE ". $whereClause;
}

// 先计算总记录数
$allResult = mysql_query($query_cj_rank, $login);
if (!$allResult) {
    die("总记录数查询失败: ". mysql_error());
}
$totalRows_cj_rank = mysql_num_rows($allResult);
$totalPages_cj_rank = ceil($totalRows_cj_rank / $maxRows_cj_rank);

// 再添加 LIMIT 子句进行分页查询
$query_limit_cj_rank = $query_cj_rank. " LIMIT ". $startRow_cj_rank. ", ". $maxRows_cj_rank;
// 执行分页查询
$result = mysql_query($query_limit_cj_rank, $login);
if (!$result) {
    die("查询失败: ". mysql_error());
}
// 构建查询字符串，用于分页链接
$queryString_cj_rank = '';
if (!empty($_GET)) {
    $param_pairs = [];
    foreach ($_GET as $key => $value) {
        if ($key!== 'pageNum_cj_rank') { // 排除 pageNum_cj_rank 参数，避免重复添加
            $param_pairs[] = urlencode($key). '='. urlencode($value);
        }
    }
    if (!empty($param_pairs)) {
        $queryString_cj_rank = '&'. implode('&', $param_pairs);
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
        共有 <?php echo $totalRows_cj_rank ;?> 条记录，目前显示第 <?php echo ($startRow_cj_rank + 1);?> 条至第 <?php echo min($startRow_cj_rank + $maxRows_cj_rank, $totalRows_cj_rank);?> 条
    </div>
    <?php if ($totalRows_cj_rank == 0) :?>
        <div class="list2" style="text-align:center;">目前还没有添加任何信息</div>
    <?php else :?>
        <?php while ($row_cj_rank = mysql_fetch_assoc($result)) :?>
            <div class="list1">
                <ul>
                <li id="user"><?php echo empty($row_cj_rank['username'])? '-' : $row_cj_rank['username'];?></li>
                <li id="psw"><?php echo empty($row_cj_rank['password'])? '-' : $row_cj_rank['password'];?></li>
                <li><?php echo empty($row_cj_rank['unam'])? '-' : $row_cj_rank['unam'];?></li>
                <li><?php echo empty($row_cj_rank['banji'])? '-' : $row_cj_rank['banji'];?></li>
                <li><?php echo empty($row_cj_rank['level'])? '-' : $row_cj_rank['level'];?></li>
                <li><?php echo empty($row_cj_rank['fun1'])? '-' : $row_cj_rank['fun1'];?></li>
                <li><?php echo empty($row_cj_rank['fun2'])? '-' : $row_cj_rank['fun2'];?></li>
                <li><?php echo empty($row_cj_rank['power'])? '-' : $row_cj_rank['power'];?></li>
                <li><a href="edit_user.php?id=<?php echo urlencode($row_cj_rank['id']);?>">修改</a></li>
                </ul>
            </div>
        <?php endwhile;?>
    <?php endif;?>
    <?php
    // 这里调用了 PaginationHelper 类的方法生成翻页链接，假设 PaginationHelper 类已定义
    echo PaginationHelper::getPaginationLinks($currentPage, $pageNum_cj_rank, $totalPages_cj_rank, $queryString_cj_rank);
    ?>
</div>
</body>
</html>