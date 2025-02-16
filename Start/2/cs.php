<?php 
// 引入数据库连接和登录验证文件
require_once('../../Connections/login.php'); 
require_once('../../Connections/is_login.php'); 

// 获取课程和班级数据
if (isset($_GET['kcm'])) {
    $_kcm = $_GET['kcm'];  // 获取课程名
    $_bj = $_GET['bj'];    // 获取班级

    // 获取当前页面和分页参数
    $currentPage = $_SERVER["PHP_SELF"];
    $maxRows_cj_rank = 20;
    $pageNum_cj_rank = 0;

    // 获取分页信息
    if (isset($_GET['pageNum_cj_rank'])) {
        $pageNum_cj_rank = $_GET['pageNum_cj_rank'];
    }
    $startRow_cj_rank = $pageNum_cj_rank * $maxRows_cj_rank;

    // 查询成绩数据
    mysql_select_db($database_login, $login);
    $query_cj_rank = "SELECT 姓名,班级,考试号,考试名,总成绩,总班,语,数,外,物,化,生,政,史,地
                      FROM (
                          SELECT 姓名,班级,考试号,kc.考试名,cj.总成绩,总班,语,数,外,物,化,生,政,史,地 
                          FROM cj
                          JOIN kc
                          USING(考试号)
                          WHERE 考试名='$_kcm' AND 班级 LIKE '$_bj'
                          ORDER BY 总成绩 DESC
                      ) a
                      JOIN (SELECT @currank := 0 ) q";
    $query_limit_cj_rank = sprintf("%s LIMIT %d, %d", $query_cj_rank, $startRow_cj_rank, $maxRows_cj_rank);
    $cj_rank = mysql_query($query_limit_cj_rank, $login) or die(mysql_error());
    $row_cj_rank = mysql_fetch_assoc($cj_rank);

    // 计算总记录数
    if (isset($_GET['totalRows_cj_rank'])) {
        $totalRows_cj_rank = $_GET['totalRows_cj_rank'];
    } else {
        $all_cj_rank = mysql_query($query_cj_rank);
        $totalRows_cj_rank = mysql_num_rows($all_cj_rank);
    }

    // 计算总页数
    $totalPages_cj_rank = ceil($totalRows_cj_rank / $maxRows_cj_rank) - 1;

    // 输出调试信息，输出班级
    echo "班级: " . $_GET['bj'];  
}
?>

<?php
// 查询课程和班级数据，用于下拉框
mysql_select_db($database_login, $login);
$query_Recordset1 = "SELECT * FROM kc ";
$Recordset1 = mysql_query($query_Recordset1, $login) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

$query_Recordset2 = "SELECT * FROM banji ";
$Recordset2 = mysql_query($query_Recordset2, $login) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员班级成绩查询</title>
<link href="style/style.css" rel="stylesheet" type="text/css">

</head>

<body>
<script>
function xuanze(){
    document.getElementById("in_kc").value=document.getElementById("kc_sel").value;
    document.getElementById("in_bj").value=document.getElementById("bj_sel").value;
    }
</script>
<div id="box">
    <div class="search">
            <form id="top1" name="kc_search" method="get" action="cs.php">
                <!-- 选择课程名 -->
                <select id="kc_sel" class=ksm onchange="xuanze()">
                    <option>考试名</option>
                    <?php do { ?>
                    <option value="<?php echo $row_Recordset1['考试名']; ?>"><?php echo $row_Recordset1['考试名']; ?></option>
                    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                </select>

                <!-- 选择班级 -->
                <select id="bj_sel" class=bj onchange="xuanze()">
                    <option>班级</option>
                    <?php do { ?>
                    <option value="<?php echo $row_Recordset2['班级']; ?>"><?php echo $row_Recordset2['班级']; ?></option>
                    <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
                </select>

                <!-- 搜索课程和班级 -->
                <input type="text" name="in_kc" id="in_kc" class=ksm placeholder="考试名" />
                <input type="text" name="in_bj" id="in_bj" class=bj placeholder="班级" />

                <!-- 隐藏课程名和班级的查询参数 -->
                <?php 
                if (isset($_REQUEST['kcm'])){
                    echo "<input type=\"hidden\" name=\"kcm\" value=\"".$_REQUEST['kcm']."\"/>";
                }
                if (isset($_REQUEST['bj'])){
                    echo "<input type=\"hidden\" name=\"bj\" value=\"".$_REQUEST['bj']."\"/>";
                }
                ?>
                <button type="submit" name="submit" class="btn-submit">点击搜索</button>
                <!-- <input type="submit" name="submit"  value="点击搜索" /> -->
            </form>
    </div>
</div>
            <?php
// 搜索课程
if (isset($_GET['submit'])) {
    mysql_select_db($database_login, $login);

    // 获取课程名和班级（确保它们都已传递）
    $words1 = isset($_GET['in_kc']) ? $_GET['in_kc'] : '';
    $words2 = isset($_GET['in_bj']) ? $_GET['in_bj'] : '';

    // 查询课程
    $query_search_kc = "SELECT 考试号, 考试名 FROM kc WHERE 考试名 LIKE '%$words1%'";
    $search_kc = mysql_query($query_search_kc, $login) or die(mysql_error());
    $row_search_kc = mysql_fetch_assoc($search_kc);
    $totalRows_search_kc = mysql_num_rows($search_kc);

    // 构建查询字符串，确保查询参数完整
    $queryString_kcm = "";
    if (!empty($_SERVER['QUERY_STRING'])) {
        $params = explode("&", $_SERVER['QUERY_STRING']);
        $newParams = array();
        foreach ($params as $param) {
            if (stristr($param, "pageNum_cj_rank") === false &&
                stristr($param, "totalRows_cj_rank") === false &&
                stristr($param, "kcm") === false &&
                stristr($param, "bj") === false) {
                array_push($newParams, $param);
            }
        }
        if (count($newParams) != 0) {
            $queryString_kcm = "&" . htmlentities(implode("&", $newParams));
        }
    }

    // 构建最终的重定向 URL
    $url = sprintf("%s?kcm=%s&bj=%s%s", $currentPage, $row_search_kc['考试名'], $words2, $queryString_kcm);

    // 跳转到新 URL
    echo "<script>window.location.href='$url';</script>";
}
?>
	</div>
	<?php
	//输出计数
	if(isset($_GET['kcm']))
	{
		echo "<div id=\"jishu\">共有 ";
		echo $totalRows_cj_rank ; 
		echo "条记录，目前显示第";
		echo ($startRow_cj_rank + 1);
		echo "条至第";
		echo min($startRow_cj_rank + $maxRows_cj_rank, $totalRows_cj_rank);
		echo "条</div>";
	}
	?>
	<div id="title3" class="title3">
		<ul>
			<li>姓名</li>
			<li>总分</li>
			<li>班排名</li>
			<li>语</li>
			<li>数</li>
			<li>外</li>
			<li>物</li>
			<li>化</li>
			<li>生</li>
			<li>政</li>
			<li>史</li>
			<li>地</li>
		</ul>
	</div>

	<div id="sss" class="list2" style="text-align:center;">目前还没有搜索任何信息</div>
			
	<?php
	//输出课程查询
	if(isset($_GET['kcm']))
	{
		$queryString_cj_rank = "";
	if (!empty($_SERVER['QUERY_STRING'])) {
	$params = explode("&", $_SERVER['QUERY_STRING']);
	$newParams = array();
	foreach ($params as $param) {
			if (stristr($param, "pageNum_cj_rank") == false && 
				stristr($param, "totalRows_cj_rank") == false &&
			stristr($param, "kcm") == false) {
			array_push($newParams, $param);
			}
	}
		if (count($newParams) != 0) {
			$queryString_cj_rank = "&" . htmlentities(implode("&", $newParams));
	}
	}
	/*$queryString_cj_rank = sprintf("&totalRows_cj_rank=%d%s", $totalRows_cj_rank, $queryString_cj_rank);*/
		
		echo "<script>document.getElementById(\"sss\").style.display=\"none\";</script>"; 
		do { 
			echo "<div class=\"list1\">";
			echo " <ul>";
			echo " 	<li>";echo empty($row_cj_rank['姓名']) ? '-' : $row_cj_rank['姓名'];  echo "</li>";
			echo " 	<li>";echo empty($row_cj_rank['总成绩']) ? '-' : $row_cj_rank['总成绩'];  echo "</li>";
			echo " 	<li>";echo empty($row_cj_rank['总班']) ? '-' : $row_cj_rank['总班'];  echo "</li>";
			echo " 	<li>";echo empty($row_cj_rank['语']) ? '-' : $row_cj_rank['语'];  echo "</li>";
			echo " 	<li>";echo empty($row_cj_rank['数']) ? '-' : $row_cj_rank['数'];  echo "</li>";
			echo " 	<li>";echo empty($row_cj_rank['外']) ? '-' : $row_cj_rank['外'];  echo "</li>";
			echo " 	<li>";echo empty($row_cj_rank['物']) ? '-' : $row_cj_rank['物'];  echo "</li>";
			echo " 	<li>";echo empty($row_cj_rank['化']) ? '-' : $row_cj_rank['化'];  echo "</li>";
			echo " 	<li>";echo empty($row_cj_rank['生']) ? '-' : $row_cj_rank['生'];  echo "</li>";
			echo " 	<li>";echo empty($row_cj_rank['政']) ? '-' : $row_cj_rank['政'];  echo "</li>";
			echo " 	<li>";echo empty($row_cj_rank['史']) ? '-' : $row_cj_rank['史'];  echo "</li>";
			echo " 	<li>";echo empty($row_cj_rank['地']) ? '-' : $row_cj_rank['地'];  echo "</li>";
			echo " </ul>";
			echo " </div>";
			} while ($row_cj_rank = mysql_fetch_assoc($cj_rank)); 
			if ($totalRows_cj_rank == 0) {
				echo "<div class=\"list2\" style=\"text-align:center;\">目前还没有添加任何信息</div>";
			} 
			echo "<div id=\"menu\">";
			if ($pageNum_cj_rank > 0 or $pageNum_cj_rank < $totalPages_cj_rank ) {
				echo "<div id=\"xzys\">";
			}
			if ($pageNum_cj_rank > 0) {
				echo "<a href=\"";
				printf("%s?kcm=%s&pageNum_cj_rank=%d%s", $currentPage,$_GET['kcm'],  0, $queryString_cj_rank);
				echo "\"><img src=\"imgs/1.png\" width=\"50px\" height=\"50px\"></a> ";
			}
			else {
				echo "<a><img src=\"imgs/w.png\" width=\"50px\" height=\"0px\"></a>";
			}
			//----
			if ($pageNum_cj_rank > 0) {
				echo "<a href=\"";
				printf("%s?kcm=%s&pageNum_cj_rank=%d%s", $currentPage,$_GET['kcm'],  max(0, $pageNum_cj_rank - 1), $queryString_cj_rank); 
				echo "\"><img src=\"imgs/2.png\" width=\"50px\" height=\"50px\"></a> ";
			}
			else {
				echo "<a><img src=\"imgs/w.png\" width=\"50px\" height=\"0px\"></a>";
			}
			//----
			if ($pageNum_cj_rank < $totalPages_cj_rank) {
				echo "<a href=\"";
				printf("%s?kcm=%s&pageNum_cj_rank=%d%s", $currentPage,$_GET['kcm'], min($totalPages_cj_rank, $pageNum_cj_rank + 1), $queryString_cj_rank);
				echo "\"><img src=\"imgs/3.png\" width=\"50px\" height=\"50px\"></a> ";
			}
			else {
				echo "<a><img src=\"imgs/w.png\" width=\"50px\" height=\"0px\"></a>";
			}
			if ($pageNum_cj_rank < $totalPages_cj_rank) {
				echo "<a href=\"";
				printf("%s?kcm=%s&pageNum_cj_rank=%d%s",  $currentPage, $_GET['kcm'],$totalPages_cj_rank, $queryString_cj_rank); 
				echo "\"><img src=\"imgs/4.png\" width=\"50px\" height=\"50px\"></a> ";
			}
			else {
				echo "<a><img src=\"imgs/w.png\" width=\"50px\" height=\"0px\"></a>";
			}
			echo "</div></div>";
		}
	?>
</div>
</body>
</html>