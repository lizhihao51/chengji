<?php require_once('../../Connections/login.php'); ?>
<?php require_once('../../Connections/is_login.php'); ?>
<?php
$level=$_COOKIE["level"];
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_cj_msg = 10;
$pageNum_cj_msg = 0;
if (isset($_GET['pageNum_cj_msg'])) {
  $pageNum_cj_msg = $_GET['pageNum_cj_msg'];
}
$startRow_cj_msg = $pageNum_cj_msg * $maxRows_cj_msg;
$unam=$_COOKIE["admin"];
mysql_select_db($database_login, $login);
$query_cj_msg = "SELECT * FROM cj join kc using(考试号)  WHERE 姓名='$unam' AND 届别='$level'";
$query_limit_cj_msg = sprintf("%s LIMIT %d, %d", $query_cj_msg, $startRow_cj_msg, $maxRows_cj_msg);
$cj_msg = mysql_query($query_limit_cj_msg, $login) or die(mysql_error());
$row_cj_msg = mysql_fetch_assoc($cj_msg);

if (isset($_GET['totalRows_cj_msg'])) {
  $totalRows_cj_msg = $_GET['totalRows_cj_msg'];
} else {
  $all_cj_msg = mysql_query($query_cj_msg);
  $totalRows_cj_msg = mysql_num_rows($all_cj_msg);
}
$totalPages_cj_msg = ceil($totalRows_cj_msg/$maxRows_cj_msg)-1;

$queryString_cj_msg = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_cj_msg") == false && 
        stristr($param, "totalRows_cj_msg") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_cj_msg = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_cj_msg = sprintf("&totalRows_cj_msg=%d%s", $totalRows_cj_msg, $queryString_cj_msg);
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

  <div id="jishu">共有 <?php echo $totalRows_cj_msg ?> 条记录，目前显示第<?php echo ($startRow_cj_msg + 1) ?>条至第<?php echo min($startRow_cj_msg + $maxRows_cj_msg, $totalRows_cj_msg) ?>条</div>
  <div id="title1">
    <ul>
      <li>姓名</li>
      <li>考试名</li>
      <li>总分</li>
      <li>语</li>
      <li>数</li>
      <li>外</li>
      <li>物</li>
      <li>化</li>
      <li>生</li>
      <li>政</li>
      <li>史</li>
      <li>地</li>
      <br>
    </ul>
    <div id="spacer"></div>
  </div>
  
  <?php do { ?>
    <div class="list1">
      <ul>
      <li><?php echo empty($row_cj_msg['姓名']) ? '-' : $row_cj_msg['姓名']; ?></li>
      <li><?php echo empty($row_cj_msg['考试名']) ? '-' : $row_cj_msg['考试名']; ?></li>
      <li><?php echo empty($row_cj_msg['总成绩']) ? '-' : $row_cj_msg['总成绩']; ?></li>
      <li><?php echo empty($row_cj_msg['语']) ? '-' : $row_cj_msg['语']; ?></li>
      <li><?php echo empty($row_cj_msg['数']) ? '-' : $row_cj_msg['数']; ?></li>
      <li><?php echo empty($row_cj_msg['外']) ? '-' : $row_cj_msg['外']; ?></li>
      <li><?php echo empty($row_cj_msg['物']) ? '-' : $row_cj_msg['物']; ?></li>
      <li><?php echo empty($row_cj_msg['化']) ? '-' : $row_cj_msg['化']; ?></li>
      <li><?php echo empty($row_cj_msg['生']) ? '-' : $row_cj_msg['生']; ?></li>
      <li><?php echo empty($row_cj_msg['政']) ? '-' : $row_cj_msg['政']; ?></li>
      <li><?php echo empty($row_cj_msg['史']) ? '-' : $row_cj_msg['史']; ?></li>
      <li><?php echo empty($row_cj_msg['地']) ? '-' : $row_cj_msg['地']; ?></li>
      <li>排  名</li>
      <li>班/级</li>
      <li><?php echo empty($row_cj_msg['总班']) ? '-' : $row_cj_msg['总班']; ?>/<?php echo empty($row_cj_msg['总级']) ? '-' : $row_cj_msg['总级']; ?></li>
      <li><?php echo empty($row_cj_msg['语班']) ? '-' : $row_cj_msg['语班']; ?>/<?php echo empty($row_cj_msg['语级']) ? '-' : $row_cj_msg['语级']; ?></li>
      <li><?php echo empty($row_cj_msg['数班']) ? '-' : $row_cj_msg['数班']; ?>/<?php echo empty($row_cj_msg['数级']) ? '-' : $row_cj_msg['数级']; ?></li>
      <li><?php echo empty($row_cj_msg['外班']) ? '-' : $row_cj_msg['外班']; ?>/<?php echo empty($row_cj_msg['外级']) ? '-' : $row_cj_msg['外级']; ?></li>
      <li><?php echo empty($row_cj_msg['物班']) ? '-' : $row_cj_msg['物班']; ?>/<?php echo empty($row_cj_msg['物级']) ? '-' : $row_cj_msg['物级']; ?></li>
      <li><?php echo empty($row_cj_msg['化班']) ? '-' : $row_cj_msg['化班']; ?>/<?php echo empty($row_cj_msg['化级']) ? '-' : $row_cj_msg['化级']; ?></li>
      <li><?php echo empty($row_cj_msg['生班']) ? '-' : $row_cj_msg['生班']; ?>/<?php echo empty($row_cj_msg['生级']) ? '-' : $row_cj_msg['生级']; ?></li>
      <li><?php echo empty($row_cj_msg['政班']) ? '-' : $row_cj_msg['政班']; ?>/<?php echo empty($row_cj_msg['政级']) ? '-' : $row_cj_msg['政级']; ?></li>
      <li><?php echo empty($row_cj_msg['史班']) ? '-' : $row_cj_msg['史班']; ?>/<?php echo empty($row_cj_msg['史级']) ? '-' : $row_cj_msg['史级']; ?></li>
      <li><?php echo empty($row_cj_msg['地班']) ? '-' : $row_cj_msg['地班']; ?>/<?php echo empty($row_cj_msg['地级']) ? '-' : $row_cj_msg['地级']; ?></li>

      </ul>
    </div>
    <?php } while ($row_cj_msg = mysql_fetch_assoc($cj_msg)); ?>
  <?php if ($totalRows_cj_msg == 0) { // Show if recordset empty ?>
    <div class="list2" style="text-align:center;">目前还没有添加任何信息</div>
  <?php } // Show if recordset empty ?>
<div id="menu">
  <?php if ($pageNum_cj_msg > 0) { // Show if not first page ?>
    <a href="<?php printf("%s?pageNum_cj_msg=%d%s", $currentPage, 0, $queryString_cj_msg); ?>">第一页</a>
    <?php } // Show if not first page ?>
　
<?php if ($pageNum_cj_msg > 0) { // Show if not first page ?>
  <a href="<?php printf("%s?pageNum_cj_msg=%d%s", $currentPage, max(0, $pageNum_cj_msg - 1), $queryString_cj_msg); ?>">上一页</a>
  <?php } // Show if not first page ?>
　
<?php if ($pageNum_cj_msg < $totalPages_cj_msg) { // Show if not last page ?>
  <a href="<?php printf("%s?pageNum_cj_msg=%d%s", $currentPage, min($totalPages_cj_msg, $pageNum_cj_msg + 1), $queryString_cj_msg); ?>">下一页</a>
  <?php } // Show if not last page ?>
　
<?php if ($pageNum_cj_msg < $totalPages_cj_msg) { // Show if not last page ?>
  <a href="<?php printf("%s?pageNum_cj_msg=%d%s", $currentPage, $totalPages_cj_msg, $queryString_cj_msg); ?>">最后一页</a>
  <?php } // Show if not last page ?>
　</div>
    



</div>




</body>
</html>
<?php
mysql_free_result($cj_msg);
?>
