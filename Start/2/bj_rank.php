<?php
// 引入配置文件，假设该文件包含数据库连接信息
require_once('../../Connections/login.php'); 
require_once('../../Connections/is_login.php'); 

// 初始化变量
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_cj_rank = 20;
$pageNum_cj_rank = 0;
if (isset($_GET['pageNum_cj_rank'])) {
    $pageNum_cj_rank = $_GET['pageNum_cj_rank'];
}
$startRow_cj_rank = $pageNum_cj_rank * $maxRows_cj_rank;

// 获取搜索框的值
$searchKaoShiHao = isset($_GET['kaoShiHao'])? $_GET['kaoShiHao'] : '';	//考试号
$searchXingMing = isset($_GET['xingMing'])? $_GET['xingMing'] : '';	//姓名
$searchBanJi = isset($_GET['banJi'])? $_GET['banJi'] : '';	//班级
$searchKaoShiMing = isset($_GET['kaoShiMing'])? $_GET['kaoShiMing'] : '';  //考试名
$searchRuXueNian = isset($_GET['ruXueNian'])? $_GET['ruXueNian'] : '';	//入学年

// 获取课程数据
mysql_select_db($database_login, $login);
$courseQuery = "SELECT * FROM kc";
$courseResult = mysql_query($courseQuery, $login);
if (!$courseResult) {
    die("课程数据查询失败: ". mysql_error());
}

// 获取班级数据
mysql_select_db($database_login, $login);
$classQuery = "SELECT 班级 FROM banji";
$classResult = mysql_query($classQuery, $login);
if (!$classResult) {
    die("班级数据查询失败: ". mysql_error());
}

// 构建 WHERE 子句
$whereClause = '1 = 1';
if (!empty($searchKaoShiHao)) {
    $whereClause.= " AND cj.考试号 = '". mysql_real_escape_string($searchKaoShiHao). "'";
}
if (!empty($searchXingMing)) {
    $whereClause.= " AND cj.姓名 LIKE '%". mysql_real_escape_string($searchXingMing). "%'";
}
if (!empty($searchBanJi)) {
    $whereClause.= " AND cj.班级 = '". mysql_real_escape_string($searchBanJi). "'";
}
if (!empty($searchKaoShiMing)) {
    $whereClause.= " AND cj.考试号 = (SELECT 考试号 FROM kc WHERE 考试名 = '". mysql_real_escape_string($searchKaoShiMing). "')";
}

// 构建 SQL 查询语句
$query_cj_rank = "SELECT cj.*, kc.考试名 FROM cj 
                  JOIN kc ON cj.考试号 = kc.考试号";
$query_cj_rank.= " WHERE ". $whereClause;

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
$row_cj_rank = mysql_fetch_assoc($result);


// 构建查询字符串，用于分页链接
$queryString_cj_rank = '';
if (!empty($_GET)) {
    $param_pairs = [];
    foreach ($_GET as $key => $value) {
        // 不再排除任何参数，确保所有参数都包含在分页链接中
        $param_pairs[] = urlencode($key). '='. urlencode($value);
    }
    if (!empty($param_pairs)) {
        $queryString_cj_rank = '?'. implode('&', $param_pairs);
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
        <form id="cj_search" name="cj_search" method="get" action="bj_rank.php">
            <p>
                考试号：<input type="text" name="kaoShiHao" value="<?php echo htmlspecialchars($searchKaoShiHao);?>">
                <!-- 姓名：<input type="text" name="xingMing" value="<?php echo htmlspecialchars($searchXingMing);?>"> -->
                班级：
                <select name="banJi">
                    <option value="">请选择班级</option>
                    <?php while ($classRow = mysql_fetch_assoc($classResult)) {?>
                        <option value="<?php echo $classRow['班级'];?>" <?php if ($classRow['班级'] == $searchBanJi) echo'selected';?>><?php echo $classRow['班级'];?></option>
                    <?php }?>
                </select>
                考试名：
                <select name="kaoShiMing">
                    <option value="">请选择考试名</option>
                    <?php while ($courseRow = mysql_fetch_assoc($courseResult)) {?>
                        <option value="<?php echo $courseRow['考试名'];?>" <?php if ($courseRow['考试名'] == $searchKaoShiMing) echo'selected';?>><?php echo $courseRow['考试名'];?></option>
                    <?php }?>
                </select>
                <input type="submit" value="搜索">
            </p>
        </form>
        <div id="title3" class="title3">
            <ul>
                <li>考试号</li>
                <li>姓名</li>
                <li>班级</li>
                <li>总分</li>
                <li>排名</li>
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
                    <li><?php echo empty($row_cj_rank['考试号'])? '-' : $row_cj_rank['考试号'];?></li>
                    <li><?php echo empty($row_cj_rank['姓名'])? '-' : $row_cj_rank['姓名'];?></li>
                    <li><?php echo empty($row_cj_rank['班级'])? '-' : $row_cj_rank['班级'];?></li>
                    <li><?php echo empty($row_cj_rank['总成绩'])? '-' : $row_cj_rank['总成绩'];?></li>
                    <li><?php echo empty($row_cj_rank['总班'])? '-' : $row_cj_rank['总班'];?></li>
                </ul>
            </div>
        <?php endwhile;?>
    <?php endif;?>
    <div id="menu">
        <?php if ($pageNum_cj_rank > 0 || $pageNum_cj_rank < $totalPages_cj_rank ) :?>
            <div id="xzys">
        <?php endif;?>
        <?php if ($pageNum_cj_rank > 0) :?>
            <a href="<?php printf("%s?pageNum_cj_rank=%d%s", $currentPage,  0, $queryString_cj_rank);?>"><img src="imgs/1.png" width="50px" height="50px"></a> 
        <?php else :?>
            <a><img src="imgs/w.png" width="50px" height="0px"></a>
        <?php endif;?>
        <?php if ($pageNum_cj_rank > 0) :?>
            <a href="<?php printf("%s?pageNum_cj_rank=%d%s", $currentPage,  max(0, $pageNum_cj_rank - 1), $queryString_cj_rank);?>"><img src="imgs/2.png" width="50px" height="50px"></a> 
        <?php else :?>
            <a><img src="imgs/w.png" width="50px" height="0px"></a>
        <?php endif;?>
        <?php if ($pageNum_cj_rank < $totalPages_cj_rank) :?>
            <a href="<?php printf("%s?pageNum_cj_rank=%d%s", $currentPage, min($totalPages_cj_rank, $pageNum_cj_rank + 1), $queryString_cj_rank);?>"><img src="imgs/3.png" width="50px" height="50px"></a> 
        <?php else :?>
            <a><img src="imgs/w.png" width="50px" height="0px"></a>
        <?php endif;?>
        <?php if ($pageNum_cj_rank < $totalPages_cj_rank) :?>
            <a href="<?php printf("%s?pageNum_cj_rank=%d%s",  $currentPage, $totalPages_cj_rank, $queryString_cj_rank);?>"><img src="imgs/4.png" width="50px" height="50px"></a> 
        <?php else :?>
            <a><img src="imgs/w.png" width="50px" height="0px"></a>
        <?php endif;?>
        </div>
    </div>
</div>
</body>
</html>