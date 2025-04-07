<?php
// 引入配置文件，假设该文件包含数据库连接信息
require_once('../../Connections/login.php');
require_once('../../Connections/is_login.php');

// 创建 mysqli 连接
$mysqli = new mysqli($host, $username, $password, $database);
if ($mysqli->connect_error) {
    die("连接失败: ". $mysqli->connect_error);
}

// 初始化分页变量
$currentPage = $_SERVER["PHP_SELF"];
$maxRows = 20;
$page = isset($_GET['pageNum_cj_rank']) ? (int)$_GET['pageNum_cj_rank'] : 0;
$offset = $page * $maxRows;

// 获取搜索框的值
$searchXianXueNian = isset($_COOKIE["time_xn"]) ? $_COOKIE["time_xn"] : '';
$searchKaoShiHao = isset($_GET['kaoShiHao']) ? $_GET['kaoShiHao'] : '';
$searchXingMing = isset($_GET['xingMing']) ? $_GET['xingMing'] : '';
$searchBanJi = isset($_GET['banJi']) ? $_GET['banJi'] : '';
$searchKaoShiMing = isset($_GET['kaoShiMing']) ? $_GET['kaoShiMing'] : '';
$searchRuXueNian = isset($_GET['ruXueNian']) ? $_GET['ruXueNian'] : '';

// 构建课程查询条件
$courseWhere = [];
if (!empty($searchXianXueNian)) {
    $courseWhere[] = "XN = '". $mysqli->real_escape_string($searchXianXueNian). "'";
}
if (!empty($searchRuXueNian)) {
    $courseWhere[] = "RXN = '". $mysqli->real_escape_string($searchRuXueNian). "'";
}
$courseWhereClause =!empty($courseWhere)? "WHERE ". implode(" AND ", $courseWhere) : "";

// 获取课程数据
$courseQuery = "SELECT * FROM kc $courseWhereClause";
$courseResult = $mysqli->query($courseQuery);
if (!$courseResult) {
    die("课程数据查询失败: ". $mysqli->error);
}

// 获取班级数据
$classQuery = "SELECT BJ FROM bj";
$classResult = $mysqli->query($classQuery);
if (!$classResult) {
    die("班级数据查询失败: ". $mysqli->error);
}

// 构建主查询 WHERE 子句
$where = [];
if (!empty($searchKaoShiHao)) {
    $where[] = "cj.KSH = '". $mysqli->real_escape_string($searchKaoShiHao). "'";
}
if (!empty($searchXingMing)) {
    $where[] = "cj.XM LIKE '%". $mysqli->real_escape_string($searchXingMing). "%'";
}
if (!empty($searchBanJi)) {
    $where[] = "cj.BJ = '". $mysqli->real_escape_string($searchBanJi). "'";
}
if (!empty($searchKaoShiMing)) {
    $where[] = "kc.KSM = '". $mysqli->real_escape_string($searchKaoShiMing). "'";
}
if (!empty($searchRuXueNian)) {
    $where[] = "kc.RXN = '". $mysqli->real_escape_string($searchRuXueNian). "'";
}
if (!empty($searchXianXueNian)) {
    $where[] = "kc.XN = '". $mysqli->real_escape_string($searchXianXueNian). "'";
}
$whereClause =!empty($where)? "WHERE ". implode(" AND ", $where) : "";

// 构建主查询 SQL
$baseQuery = "SELECT cj.*, kc.KSM FROM cj JOIN kc ON cj.KSH = kc.KSH $whereClause ORDER BY cj.KSH ASC, cj.ZCJ DESC";

// 计算总记录数
$countQuery = "SELECT COUNT(*) as total FROM ($baseQuery) AS subquery";
$countResult = $mysqli->query($countQuery);
if (!$countResult) {
    die("总记录数查询失败: ". $mysqli->error);
}
$totalRows = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $maxRows);

// 添加 LIMIT 子句进行分页查询
$limitQuery = $baseQuery. " LIMIT $offset, $maxRows";
$result = $mysqli->query($limitQuery);
if (!$result) {
    die("查询失败: ". $mysqli->error);
}

// 构建查询字符串，用于分页链接
$queryStringArray = [];
foreach ($_GET as $key => $value) {
    if ($key!== 'pageNum_cj_rank') {
        $queryStringArray[$key] = $value;
    }
}
$queryString = http_build_query($queryStringArray);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>管理员默认页</title>
    <link href="style/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div id="box">
        <div class="search">
            <form id="cj_search" name="cj_search" method="get" action="all_rank.php">
                <p>
                    考试号：<input type="text" name="kaoShiHao" value="<?php echo htmlspecialchars($searchKaoShiHao);?>">
                    入学年：
                    <select name="ruXueNian">
                        <option value="">请选择入学年</option>
                        <option value="2022" <?php if ($searchRuXueNian === '2022') echo'selected';?>>22</option>
                        <option value="2023" <?php if ($searchRuXueNian === '2023') echo'selected';?>>23</option>
                        <option value="2024" <?php if ($searchRuXueNian === '2024') echo'selected';?>>24</option>
                    </select>
                    考试名：
                    <select name="kaoShiMing">
                        <option value="">请选择考试名</option>
                        <?php while ($courseRow = $courseResult->fetch_assoc()) {?>
                            <option value="<?php echo $courseRow['KSM'];?>" <?php if ($courseRow['KSM'] === $searchKaoShiMing) echo'selected';?>><?php echo $courseRow['KSM'];?></option>
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
                    <li>级排名</li>
                    <li>班排名</li>
                </ul>
            </div>
        </div>
        <div id="jishu">
            共有 <?php echo $totalRows;?> 条记录，目前显示第 <?php echo ($offset + 1);?> 条至第 <?php echo min($offset + $maxRows, $totalRows);?> 条
        </div>
        <?php if ($totalRows === 0) :?>
            <div class="list2" style="text-align:center;">目前还没有添加任何信息</div>
        <?php else :?>
            <?php while ($row = $result->fetch_assoc()) :?>
                <div class="list1">
                    <ul>
                        <li><?php echo empty($row['KSH'])? '-' : $row['KSH'];?></li>
                        <li><?php echo empty($row['XM'])? '-' : $row['XM'];?></li>
                        <li><?php echo empty($row['BJ'])? '-' : $row['BJ'];?></li>
                        <li><?php echo empty($row['ZCJ'])? '-' : $row['ZCJ'];?></li>
                        <li><?php echo empty($row['ZJPM'])? '-' : $row['ZJPM'];?></li>
                        <li><?php echo empty($row['ZBPM'])? '-' : $row['ZBPM'];?></li>
                    </ul>
                </div>
            <?php endwhile;?>
        <?php endif;?>
        <div id="menu">
            <?php if ($page > 0 || $page < $totalPages - 1) :?>
                <div id="xzys">
                    <?php if ($page > 0) :?>
                        <a href="<?php printf("%s?pageNum_cj_rank=%d&%s", $currentPage, 0, $queryString);?>"><img src="imgs/1.png" width="50px" height="50px"></a>
                    <?php else :?>
                        <a><img src="imgs/w.png" width="50px" height="0px"></a>
                    <?php endif;?>
                    <?php if ($page > 0) :?>
                        <a href="<?php printf("%s?pageNum_cj_rank=%d&%s", $currentPage, $page - 1, $queryString);?>"><img src="imgs/2.png" width="50px" height="50px"></a>
                    <?php else :?>
                        <a><img src="imgs/w.png" width="50px" height="0px"></a>
                    <?php endif;?>
                    <?php if ($page < $totalPages - 1) :?>
                        <a href="<?php printf("%s?pageNum_cj_rank=%d&%s", $currentPage, $page + 1, $queryString);?>"><img src="imgs/3.png" width="50px" height="50px"></a>
                    <?php else :?>
                        <a><img src="imgs/w.png" width="50px" height="0px"></a>
                    <?php endif;?>
                    <?php if ($page < $totalPages - 1) :?>
                        <a href="<?php printf("%s?pageNum_cj_rank=%d&%s", $currentPage, $totalPages - 1, $queryString);?>"><img src="imgs/4.png" width="50px" height="50px"></a>
                    <?php else :?>
                        <a><img src="imgs/w.png" width="50px" height="0px"></a>
                    <?php endif;?>
                </div>
            <?php endif;?>
        </div>
    </div>
</body>
</html>