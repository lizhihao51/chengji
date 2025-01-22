<?php 
require_once('../../Connections/login.php'); 
require_once('../../Connections/is_login.php'); 


$currentPage = $_SERVER["PHP_SELF"];

$maxRows_cj_rank = 20;
$pageNum_cj_rank = 0;
if (isset($_GET['pageNum_cj_rank'])) {
    $pageNum_cj_rank = $_GET['pageNum_cj_rank'];
}
$startRow_cj_rank = $pageNum_cj_rank * $maxRows_cj_rank;

mysql_select_db($database_login, $login);
// 修改查询语句，直接从 kc 表中获取所需数据
$query_cj_rank = "SELECT 考试号, 学年, 考试名, 届别, 年级, 总分, 备注 FROM kc";
$query_limit_cj_rank = sprintf("%s LIMIT %d, %d", $query_cj_rank, $startRow_cj_rank, $maxRows_cj_rank);
$cj_rank = mysql_query($query_limit_cj_rank, $login) or die(mysql_error());
$row_cj_rank = mysql_fetch_assoc($cj_rank);

if (isset($_GET['totalRows_cj_rank'])) {
    $totalRows_cj_rank = $_GET['totalRows_cj_rank'];
} else {
    $all_cj_rank = mysql_query($query_cj_rank);
    $totalRows_cj_rank = mysql_num_rows($all_cj_rank);
}
$totalPages_cj_rank = ceil($totalRows_cj_rank/$maxRows_cj_rank);

// 下拉框数据获取
mysql_select_db($database_login, $login);
$query_Recordset1 = "SELECT * FROM kc";
$Recordset1 = mysql_query($query_Recordset1, $login) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="style/style.css" rel="stylesheet" type="text/css">

</head>

<body>
<div id="box">
<div class="search">
<div id="title3" class="title3">
		<ul>
			<li>学年</li>
			<li>考试号</li>
			<li>考试名</li>
			<li>入学年</li>
			<li>级别</li>
			<li>总分</li>
			<li>备注</li>
		</ul>
	</div>
</div> 
    <?php
    // 输出计数
    echo "<div id=\"jishu\">共有 ";
    echo $totalRows_cj_rank ; 
    echo "条记录，目前显示第";
    echo ($startRow_cj_rank + 1);
    echo "条至第";
    echo min($startRow_cj_rank + $maxRows_cj_rank, $totalRows_cj_rank);
    echo "条</div>";

    // 输出课程查询
    $queryString_cj_rank = "";
    if (!empty($_SERVER['QUERY_STRING'])) {
        $params = explode("&", $_SERVER['QUERY_STRING']);
        $newParams = array();
        foreach ($params as $param) {
            if (stristr($param, "pageNum_cj_rank") == false && 
                stristr($param, "totalRows_cj_rank") == false) {
                array_push($newParams, $param);
            }
        }
        if (count($newParams)!= 0) {
            $queryString_cj_rank = "&". htmlentities(implode("&", $newParams));
        }
    }

    echo "<script>document.getElementById(\"sss\").style.display=\"none\";</script>"; 
    do { 
        echo "<div class=\"list1\">";
        echo " <ul>";
        echo " 	<li>";echo empty($row_cj_rank['学年'])? '-' : $row_cj_rank['学年'];  echo "</li>";
        echo " 	<li>";echo empty($row_cj_rank['考试号'])? '-' : $row_cj_rank['考试号'];  echo "</li>";
        echo " 	<li>";echo empty($row_cj_rank['考试名'])? '-' : $row_cj_rank['考试名'];  echo "</li>";
        echo " 	<li>";echo empty($row_cj_rank['届别'])? '-' : $row_cj_rank['届别'];  echo "</li>";
        echo " 	<li>";echo empty($row_cj_rank['年级'])? '-' : $row_cj_rank['年级'];  echo "</li>";
        echo " 	<li>";echo empty($row_cj_rank['总分'])? '-' : $row_cj_rank['总分'];  echo "</li>";
        echo " 	<li>";echo empty($row_cj_rank['备注'])? '-' : $row_cj_rank['备注'];  echo "</li>";
        echo " </ul>";
        echo " </div>";
    } while ($row_cj_rank = mysql_fetch_assoc($cj_rank)); 
    if ($totalRows_cj_rank == 0) {
        echo "<div class=\"list2\" style=\"text-align:center;\">目前还没有添加任何信息</div>";
    } 

    echo "<div id=\"menu\">";
    if ($pageNum_cj_rank > 0 || $pageNum_cj_rank < $totalPages_cj_rank ) {
        echo "<div id=\"xzys\">";
    }
    if ($pageNum_cj_rank > 0) {
        echo "<a href=\"";
        printf("%s?pageNum_cj_rank=%d%s", $currentPage,  0, $queryString_cj_rank);
        echo "\"><img src=\"imgs/1.png\" width=\"50px\" height=\"50px\"></a> ";
    }
    else {
        echo "<a><img src=\"imgs/w.png\" width=\"50px\" height=\"0px\"></a>";
    }
    //----
    if ($pageNum_cj_rank > 0) {
        echo "<a href=\"";
        printf("%s?pageNum_cj_rank=%d%s", $currentPage,  max(0, $pageNum_cj_rank - 1), $queryString_cj_rank); 
        echo "\"><img src=\"imgs/2.png\" width=\"50px\" height=\"50px\"></a> ";
    }
    else {
        echo "<a><img src=\"imgs/w.png\" width=\"50px\" height=\"0px\"></a>";
    }
    //----
    if ($pageNum_cj_rank < $totalPages_cj_rank) {
        echo "<a href=\"";
        printf("%s?pageNum_cj_rank=%d%s", $currentPage, min($totalPages_cj_rank, $pageNum_cj_rank + 1), $queryString_cj_rank);
        echo "\"><img src=\"imgs/3.png\" width=\"50px\" height=\"50px\"></a> ";
    }
    else {
        echo "<a><img src=\"imgs/w.png\" width=\"50px\" height=\"0px\"></a>";
    }
    if ($pageNum_cj_rank < $totalPages_cj_rank) {
        echo "<a href=\"";
        printf("%s?pageNum_cj_rank=%d%s",  $currentPage, $totalPages_cj_rank, $queryString_cj_rank); 
        echo "\"><img src=\"imgs/4.png\" width=\"50px\" height=\"50px\"></a> ";
    }
    else {
        echo "<a><img src=\"imgs/w.png\" width=\"50px\" height=\"0px\"></a>";
    }
    echo "</div></div>";
?>
</div>
</body>
</html>