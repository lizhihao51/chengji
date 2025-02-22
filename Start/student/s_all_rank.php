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

// $searchXingMing=$_COOKIE["admin"];
$searchRuXueNian=$_COOKIE["level"];
$searchXianXueNian=$_COOKIE["time_xn"];

// $searchBanJi = $_COOKIE["bj"];	//班级
$searchKaoShiHao = isset($_GET['kaoShiHao'])? $_GET['kaoShiHao'] : '';	//考试号
$searchKaoShiMing = isset($_GET['kaoShiMing'])? $_GET['kaoShiMing'] : '';  //考试名

// 获取课程数据
mysql_select_db($database_login, $login);
// 根据入学年筛选课程数据
$courseQuery = "SELECT * FROM kc WHERE RXN LIKE '$searchRuXueNian'AND XN LIKE '$searchXianXueNian'";

$courseResult = mysql_query($courseQuery, $login);
if (!$courseResult) {
    die("课程数据查询失败: ". mysql_error());
}

// 获取班级数据
mysql_select_db($database_login, $login);
$classQuery = "SELECT BJ FROM bj";
$classResult = mysql_query($classQuery, $login);
if (!$classResult) {
    die("班级数据查询失败: ". mysql_error());
}

// 构建 WHERE 子句
$whereClause = '1 = 1';
if (!empty($searchKaoShiHao)) {
    $whereClause.= " AND cj.KSH = '". mysql_real_escape_string($searchKaoShiHao). "'";
}
if (!empty($searchXingMing)) {
    $whereClause.= " AND cj.XM LIKE '%". mysql_real_escape_string($searchXingMing). "%'";
}
if (!empty($searchBanJi)) {
    $whereClause.= " AND cj.BJ = '". mysql_real_escape_string($searchBanJi). "'";
}
if (!empty($searchKaoShiMing)) {
    $whereClause.= " AND cj.KSH = (SELECT KSH FROM kc WHERE KSM = '". mysql_real_escape_string($searchKaoShiMing). "')";
}
if (!empty($searchRuXueNian)) {
    $whereClause.= " AND cj.KSH IN (SELECT KSH FROM kc WHERE RXN = '". mysql_real_escape_string($searchRuXueNian). "')";
}
if (!empty($searchXianXueNian)) {
    $whereClause.= " AND cj.KSH IN (SELECT KSH FROM kc WHERE XN = '". mysql_real_escape_string($searchXianXueNian). "')";
}

// 构建 SQL 查询语句
$query_cj_rank = "SELECT cj.*, kc.KSM FROM cj 
                JOIN kc ON cj.KSH = kc.KSH";
$query_cj_rank.= " WHERE ". $whereClause;
// 添加 ORDER BY 子句，先按考试号升序排序，再按总成绩降序排序
$query_cj_rank.= " ORDER BY  cj.KSH ASC, cj.ZCJ Desc";

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
        <form id="cj_search" name="cj_search" method="get" action="s_all_rank.php">
            <p>
                考试号：<input type="text" name="kaoShiHao" value="<?php echo htmlspecialchars($searchKaoShiHao);?>">
                <!-- 入学年：
                <select name="ruXueNian">
                    <option value="">请选择入学年</option>
   
                        <option value="2022">22</option>
						<option value="2023">23</option>
						<option value="2024">24</option>
                </select> -->
				考试名：
                <select name="kaoShiMing">
				<option value="">请选择考试名</option>
                    <?php while ($courseRow = mysql_fetch_assoc($courseResult)) {?>
                        <option value="<?php echo $courseRow['KSM'];?>" <?php if ($courseRow['KSM'] == $searchKaoShiMing) echo'selected';?>><?php echo $courseRow['KSM'];?></option>
                    <?php }?>
                </select>
                <input type="submit" class="btn-submit" value="搜索">
            </p>
        </form>
        <div id="title3" class="title3">
            <ul>
                <li>考试号</li>
				<li>考试名</li>
                <li>姓名</li>
                <li>班级</li>
                <li>总分</li>
                <li>班排名</li>
				<li>总排名</li>
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
                    <li><?php echo empty($row_cj_rank['KSH'])? '-' : $row_cj_rank['KSH'];?></li>
                    <li><?php echo empty($row_cj_rank['KSM'])? '-' : $row_cj_rank['KSM'];?></li>
					<li><?php echo empty($row_cj_rank['XM'])? '-' : $row_cj_rank['XM'];?></li>
                    <li><?php echo empty($row_cj_rank['BJ'])? '-' : $row_cj_rank['BJ'];?></li>
                    <li><?php echo empty($row_cj_rank['ZCJ'])? '-' : $row_cj_rank['ZCJ'];?></li>
                    <li><?php echo empty($row_cj_rank['ZBPM'])? '-' : $row_cj_rank['ZBPM'];?></li>
					<li><?php echo empty($row_cj_rank['ZJPM'])? '-' : $row_cj_rank['ZJPM'];?></li>
                </ul>
            </div>
        <?php endwhile;?>
    <?php endif;?>
    <div id="menu">
        <?php if ($pageNum_cj_rank > 0 || $pageNum_cj_rank < $totalPages_cj_rank-1 ) :?>
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
        <?php if ($pageNum_cj_rank+1 < $totalPages_cj_rank) :?>
            <a href="<?php printf("%s?pageNum_cj_rank=%d%s", $currentPage, min($totalPages_cj_rank-1, $pageNum_cj_rank + 1), $queryString_cj_rank);?>"><img src="imgs/3.png" width="50px" height="50px"></a> 
        <?php else :?>
            <a><img src="imgs/w.png" width="50px" height="0px"></a>
        <?php endif;?>
        <?php if ($pageNum_cj_rank+1 < $totalPages_cj_rank) :?>
            <a href="<?php printf("%s?pageNum_cj_rank=%d%s",  $currentPage, $totalPages_cj_rank-1, $queryString_cj_rank);?>"><img src="imgs/4.png" width="50px" height="50px"></a> 
        <?php else :?>
            <a><img src="imgs/w.png" width="50px" height="0px"></a>
        <?php endif;?>
        </div>
    </div>
</div>
</body>
</html>