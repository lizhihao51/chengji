<?php
// 引入配置文件，假设该文件包含数据库连接信息
require_once('../../Connections/login.php');
require_once('../../Connections/is_login.php');
require_once('../../Connections/pagination.php');


$unam = urldecode($_COOKIE['admin']);
$level = urldecode($_COOKIE['level']);
$fun = urldecode($_COOKIE['fun']);
$bj = urldecode($_COOKIE['bj']);

// 连接数据库
mysql_select_db($database_login, $login);

// 初始化变量
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_cj_rank = 20;
$pageNum_cj_rank = 0;
if (isset($_GET['pageNum_cj_rank'])) {
    $pageNum_cj_rank = $_GET['pageNum_cj_rank'];
}
$startRow_cj_rank = $pageNum_cj_rank * $maxRows_cj_rank;

// 获取搜索框的值
// $searchJieBie = isset($_GET['jieBie'])? $_GET['jieBie'] : '';
// $searchXingMing = isset($_GET['xingMing'])? $_GET['xingMing'] : '';
// $searchKaoShiMing = isset($_GET['kaoShiMing'])? $_GET['kaoShiMing'] : '';  //考试名
// $searchKaoShiHao = isset($_GET['kaoShiHao'])? $_GET['kaoShiHao'] : '';	//考试号

// 构建 WHERE 子句
$whereClause = '1 = 1';
if (!empty($level)) {
    $whereClause.= " AND RXN LIKE '%". mysql_real_escape_string($level, $login). "%'";
}
if (!empty($unam)) {
    $whereClause.= " AND cj.XM LIKE '%". mysql_real_escape_string($unam, $login). "%'";
}

// 构建 SQL 查询语句
$query_cj_rank = "SELECT 
    cj.KSH,
    kc.KSM,
    cj.XM,
    cj.BJ,
    cj.ZCJ,
    cj.ZBPM,
    cj.ZJPM,
    cj.YWCJ,
    cj.YWBP,
    cj.YWJP,
    cj.SXCJ,
    cj.SXBP,
    cj.SXJP,
    cj.WYCJ,
    cj.WYBP,
    cj.WYJP,
    cj.WLCJ,
    cj.WLBP,
    cj.WLJP,
    cj.HXCJ,
    cj.HXBP,
    cj.HXJP,
    cj.SWCJ,
    cj.SWBP,
    cj.SWJP,
    cj.ZZCJ,
    cj.ZZBP,
    cj.ZZJP,
    cj.LSCJ,
    cj.LSBP,
    cj.LSJP,
    cj.DLCJ,
    cj.DLBP,
    cj.DLJP,
    -- 处理pjf表无数据时的情况，使用IFNULL函数
    IFNULL(MAX(CASE WHEN pjf.XK = '语文' THEN pjf.BPJF END), 0) AS YWBPJF,
    IFNULL(MAX(CASE WHEN pjf.XK = '数学' THEN pjf.BPJF END), 0) AS SXBPJF,
    IFNULL(MAX(CASE WHEN pjf.XK = '英语' THEN pjf.BPJF END), 0) AS WYBPJF,
    IFNULL(MAX(CASE WHEN pjf.XK = '物理' THEN pjf.BPJF END), 0) AS WLBPJF,
    IFNULL(MAX(CASE WHEN pjf.XK = '化学' THEN pjf.BPJF END), 0) AS HXBPJF,
    IFNULL(MAX(CASE WHEN pjf.XK = '生物' THEN pjf.BPJF END), 0) AS SWBPJF,
    IFNULL(MAX(CASE WHEN pjf.XK = '政治' THEN pjf.BPJF END), 0) AS ZZBPJF,
    IFNULL(MAX(CASE WHEN pjf.XK = '历史' THEN pjf.BPJF END), 0) AS LSBPJF,
    IFNULL(MAX(CASE WHEN pjf.XK = '地理' THEN pjf.BPJF END), 0) AS DLBPJF,
    IFNULL(MAX(CASE WHEN pjf.XK = '语文' THEN pjf.JPJF END), 0) AS YWJPJF,
    IFNULL(MAX(CASE WHEN pjf.XK = '数学' THEN pjf.JPJF END), 0) AS SXJPJF,
    IFNULL(MAX(CASE WHEN pjf.XK = '英语' THEN pjf.JPJF END), 0) AS WYJPJF,
    IFNULL(MAX(CASE WHEN pjf.XK = '物理' THEN pjf.JPJF END), 0) AS WLJPJF,
    IFNULL(MAX(CASE WHEN pjf.XK = '化学' THEN pjf.JPJF END), 0) AS HXJPJF,
    IFNULL(MAX(CASE WHEN pjf.XK = '生物' THEN pjf.JPJF END), 0) AS SWJPJF,
    IFNULL(MAX(CASE WHEN pjf.XK = '政治' THEN pjf.JPJF END), 0) AS ZZJPJF,
    IFNULL(MAX(CASE WHEN pjf.XK = '历史' THEN pjf.JPJF END), 0) AS LSJPJF,
    IFNULL(MAX(CASE WHEN pjf.XK = '地理' THEN pjf.JPJF END), 0) AS DLJPJF
FROM 
    cj
JOIN 
    kc ON cj.KSH = kc.KSH
LEFT JOIN 
    pjf ON cj.KSH = pjf.KSH AND cj.BJ = pjf.BJ
WHERE 
    ". $whereClause. "
GROUP BY 
    cj.KSH,
    cj.XM,
    cj.BJ,
    cj.ZCJ,
    cj.ZBPM,
    cj.ZJPM,
    cj.YWCJ,
    cj.YWBP,
    cj.YWJP,
    cj.SXCJ,
    cj.SXBP,
    cj.SXJP,
    cj.WYCJ,
    cj.WYBP,
    cj.WYJP,
    cj.WLCJ,
    cj.WLBP,
    cj.WLJP,
    cj.HXCJ,
    cj.HXBP,
    cj.HXJP,
    cj.SWCJ,
    cj.SWBP,
    cj.SWJP,
    cj.ZZCJ,
    cj.ZZBP,
    cj.ZZJP,
    cj.LSCJ,
    cj.LSBP,
    cj.LSJP,
    cj.DLCJ,
    cj.DLBP,
    cj.DLJP";

// 先计算总记录数
$allResult = mysql_query($query_cj_rank, $login);
if (!$allResult) {
    die("总记录数查询失败: ". mysql_error($login));
}
$totalRows_cj_rank = mysql_num_rows($allResult);
$totalPages_cj_rank = ceil($totalRows_cj_rank / $maxRows_cj_rank);

// 再添加 LIMIT 子句进行分页查询
$query_limit_cj_rank = $query_cj_rank. " LIMIT ". $startRow_cj_rank. ", ". $maxRows_cj_rank;

// 执行分页查询
$result = mysql_query($query_limit_cj_rank, $login);
if (!$result) {
    die("查询失败: ". mysql_error($login));
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
    <form id="cj_search" name="cj_search" method="get" action="my_cj.php"hidden>
            <p hidden="">
                考试号：<input type="text" name="kaoShiHao" value="<?php echo htmlspecialchars($searchKaoShiHao);?>">
                入学年：
                <select name="ruXueNian">
                    <option value="">请选择入学年</option>
   
                        <option value="2022">22</option>
						<option value="2023">23</option>
						<option value="2024">24</option>
                </select>
                姓名：<input type="text" name="xingMing" value="<?php echo htmlspecialchars($searchXingMing);?>">
                班级：
                <select name="banJi">
                    <option value="">请选择班级</option>
                    <?php while ($classRow = mysql_fetch_assoc($classResult)) {?>
                        <option value="<?php echo $classRow['BJ'];?>" <?php if ($classRow['BJ'] == $searchBanJi) echo'selected';?>><?php echo $classRow['BJ'];?></option>
                    <?php }?>
                </select>
                考试名：
                <select name="kaoShiMing">
                    <option value="">请选择考试名</option>
                    <?php while ($courseRow = mysql_fetch_assoc($courseResult)) {?>
                        <option value="<?php echo $courseRow['KSM'];?>" <?php if ($courseRow['KSM'] == $searchKaoShiMing) echo'selected';?>><?php echo $courseRow['KSM'];?></option>
                    <?php }?>
                </select>
                <input type="submit" value="搜索">
            </p>
        </form>
        <div id="title3" class="title3">
            <ul>
                <li>姓名</li>
                <li>考试名</li>
                <li>总分</li>
                <li>语文</li>
                <li>数学</li>
                <li>外语</li>
                <li>物理</li>
                <li>化学</li>
                <li>生物</li>
                <li>政治</li>
                <li>历史</li>
                <li>地理</li>
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
                    <li><?php echo empty($row_cj_rank['XM'])? '-' : $row_cj_rank['XM'];?></li>
                    <li><?php echo empty($row_cj_rank['KSM'])? '-' : $row_cj_rank['KSM'];?></li>
                    <li><?php echo empty($row_cj_rank['ZCJ'])? '-' : $row_cj_rank['ZCJ'];?></li>
                    <li><?php echo empty($row_cj_rank['YWCJ'])? '-' : $row_cj_rank['YWCJ'];?></li>
                    <li><?php echo empty($row_cj_rank['SXCJ'])? '-' : $row_cj_rank['SXCJ'];?></li>
                    <li><?php echo empty($row_cj_rank['WYCJ'])? '-' : $row_cj_rank['WYCJ'];?></li>
                    <li><?php echo empty($row_cj_rank['WLCJ'])? '-' : $row_cj_rank['WLCJ'];?></li>
                    <li><?php echo empty($row_cj_rank['HXCJ'])? '-' : $row_cj_rank['HXCJ'];?></li>
                    <li><?php echo empty($row_cj_rank['SWCJ'])? '-' : $row_cj_rank['SWCJ'];?></li>
                    <li><?php echo empty($row_cj_rank['ZZCJ'])? '-' : $row_cj_rank['ZZCJ'];?></li>
                    <li><?php echo empty($row_cj_rank['LSCJ'])? '-' : $row_cj_rank['LSCJ'];?></li>
                    <li><?php echo empty($row_cj_rank['DLCJ'])? '-' : $row_cj_rank['DLCJ'];?></li>
                    
                    <li>排名</li>
                    <li>班/级</li>
                    <li><?php echo empty($row_cj_rank['ZBPM'])? '-' : $row_cj_rank['ZBPM'];?>/<?php echo empty($row_cj_rank['ZJPM'])? '-' : $row_cj_rank['ZJPM'];?></li>
                    <li><?php echo empty($row_cj_rank['YWBP'])? '-' : $row_cj_rank['YWBP'];?>/<?php echo empty($row_cj_rank['YWJP'])? '-' : $row_cj_rank['YWJP'];?></li>
                    <li><?php echo empty($row_cj_rank['SXBP'])? '-' : $row_cj_rank['SXBP'];?>/<?php echo empty($row_cj_rank['SXJP'])? '-' : $row_cj_rank['SXJP'];?></li>
                    <li><?php echo empty($row_cj_rank['WYBP'])? '-' : $row_cj_rank['WYBP'];?>/<?php echo empty($row_cj_rank['WYJP'])? '-' : $row_cj_rank['WYJP'];?></li>
                    <li><?php echo empty($row_cj_rank['WLBP'])? '-' : $row_cj_rank['WLBP'];?>/<?php echo empty($row_cj_rank['WLJP'])? '-' : $row_cj_rank['WLJP'];?></li>
                    <li><?php echo empty($row_cj_rank['HXBP'])? '-' : $row_cj_rank['HXBP'];?>/<?php echo empty($row_cj_rank['HXJP'])? '-' : $row_cj_rank['HXJP'];?></li>
                    <li><?php echo empty($row_cj_rank['SWBP'])? '-' : $row_cj_rank['SWBP'];?>/<?php echo empty($row_cj_rank['SWJP'])? '-' : $row_cj_rank['SWJP'];?></li>
                    <li><?php echo empty($row_cj_rank['ZZBP'])? '-' : $row_cj_rank['ZZBP'];?>/<?php echo empty($row_cj_rank['ZZJP'])? '-' : $row_cj_rank['ZZJP'];?></li>
                    <li><?php echo empty($row_cj_rank['LSBP'])? '-' : $row_cj_rank['LSBP'];?>/<?php echo empty($row_cj_rank['LSJP'])? '-' : $row_cj_rank['LSJP'];?></li>
                    <li><?php echo empty($row_cj_rank['DLBP'])? '-' : $row_cj_rank['DLBP'];?>/<?php echo empty($row_cj_rank['DLJP'])? '-' : $row_cj_rank['DLJP'];?></li>
                    
                    <li>平均分</li>
                    <li>班/级</li>
                    <li>暂无</li>
                    <li><?php echo empty($row_cj_rank['YWBPJF'])? '-' : $row_cj_rank['YWBPJF'];?>/<?php echo empty($row_cj_rank['YWJPJF'])? '-' : $row_cj_rank['YWJPJF'];?></li>
                    <li><?php echo empty($row_cj_rank['SXBPJF'])? '-' : $row_cj_rank['SXBPJF'];?>/<?php echo empty($row_cj_rank['SXJPJF'])? '-' : $row_cj_rank['SXJPJF'];?></li>
                    <li><?php echo empty($row_cj_rank['WYBPJF'])? '-' : $row_cj_rank['WYBPJF'];?>/<?php echo empty($row_cj_rank['WYJPJF'])? '-' : $row_cj_rank['WYJPJF'];?></li>
                    <li><?php echo empty($row_cj_rank['WLBPJF'])? '-' : $row_cj_rank['WLBPJF'];?>/<?php echo empty($row_cj_rank['WLJPJF'])? '-' : $row_cj_rank['WLJPJF'];?></li>
                    <li><?php echo empty($row_cj_rank['HXBPJF'])? '-' : $row_cj_rank['HXBPJF'];?>/<?php echo empty($row_cj_rank['HXJPJF'])? '-' : $row_cj_rank['HXJPJF'];?></li>
                    <li><?php echo empty($row_cj_rank['SWBPJF'])? '-' : $row_cj_rank['SWBPJF'];?>/<?php echo empty($row_cj_rank['SWJPJF'])? '-' : $row_cj_rank['SWJPJF'];?></li>
                    <li><?php echo empty($row_cj_rank['ZZBPJF'])? '-' : $row_cj_rank['ZZBPJF'];?>/<?php echo empty($row_cj_rank['ZZJPJF'])? '-' : $row_cj_rank['ZZJPJF'];?></li>
                    <li><?php echo empty($row_cj_rank['LSBPJF'])? '-' : $row_cj_rank['LSBPJF'];?>/<?php echo empty($row_cj_rank['LSJPJF'])? '-' : $row_cj_rank['LSJPJF'];?></li>
                    <li><?php echo empty($row_cj_rank['DLBPJF'])? '-' : $row_cj_rank['DLBPJF'];?>/<?php echo empty($row_cj_rank['DLJPJF'])? '-' : $row_cj_rank['DLJPJF'];?></li>
                    
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