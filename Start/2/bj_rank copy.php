<?php require_once('../../Connections/login.php'); ?>
<?php require_once('../../Connections/is_login.php'); ?>
<?php
// 获取课程和班级数据
if (isset($_GET['kcm']) && isset($_GET['in_banji'])) {
    $_kcm = $_GET['kcm'];
    $_banji = $_GET['in_banji'];

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

    $maxRows_cj_rank = 20;
    $pageNum_cj_rank = 0;
    if (isset($_GET['pageNum_cj_rank'])) {
        $pageNum_cj_rank = $_GET['pageNum_cj_rank'];
    }
    $startRow_cj_rank = $pageNum_cj_rank * $maxRows_cj_rank;

    $unam = $_COOKIE["admin"];
    mysql_select_db($database_login, $login);
    $query_st_msg = "SELECT * FROM student WHERE 姓名='$unam'";
    $st_msg = mysql_query($query_st_msg, $login) or die(mysql_error());
    $row_st_msg = mysql_fetch_assoc($st_msg);

	mysql_select_db($database_login, $login);
	$query_cj_rank = "select 姓名,班级,考试号,考试名,总成绩,总班,语,数,外,物,化,生,政,史,地 
	from(
	select 姓名,班级,考试号,考试名,总成绩,总班,语,数,外,物,化,生,政,史,地 
	from 
	(select 姓名,班级,考试号,kc.考试名,cj.总成绩,总班,语,数,外,物,化,生,政,史,地 
	from cj
	join kc
	using(考试号)
	where 考试名='$_kcm' 
	order by 总成绩 desc) a
	join (select @currank := 0 ) q
	) b";
	$query_limit_cj_rank = sprintf("%s LIMIT %d, %d", $query_cj_rank, $startRow_cj_rank, $maxRows_cj_rank);
	$cj_rank = mysql_query($query_limit_cj_rank, $login) or die(mysql_error());
	$row_cj_rank = mysql_fetch_assoc($cj_rank);

    if (isset($_GET['totalRows_cj_rank'])) {
        $totalRows_cj_rank = $_GET['totalRows_cj_rank'];
    } else {
        $all_cj_rank = mysql_query($query_cj_rank);
        $totalRows_cj_rank = mysql_num_rows($all_cj_rank);
    }
    $totalPages_cj_rank = ceil($totalRows_cj_rank / $maxRows_cj_rank) - 1;
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>成绩查询</title>
    <link href="style/style.css" rel="stylesheet" type="text/css">
    <script>
        function xuanze() {
            var kcm = document.getElementById("kc_sel").value;
            var banji = document.getElementById("bj_sel").value;
            
            // 设置隐藏字段的值
            document.getElementById("in_kc").value = kcm;
            document.getElementById("in_bj").value = banji;
        }
    </script>
</head>

<body>
    <div id="box">
	<p id="top1">
        <div class="search">
                课程名:
                <select id="kc_sel" onchange="xuanze()">
                    <option>请选择课程</option>
                    <?php
                    mysql_select_db($database_login, $login);
                    $query_Recordset1 = "SELECT * FROM kc";
                    $Recordset1 = mysql_query($query_Recordset1, $login) or die(mysql_error());
                    while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)) {
                        echo "<option value=\"" . $row_Recordset1['考试名'] . "\">" . $row_Recordset1['考试名'] . "</option>";
                    }
                    ?>
                </select>
                班级:
                <select id="bj_sel" onchange="xuanze()">
                    <option>请选择班级</option>
                    <?php
                    mysql_select_db($database_login, $login);
                    $query_banji = "SELECT DISTINCT 班级 FROM banji";
                    $banji_result = mysql_query($query_banji, $login) or die(mysql_error());
                    while ($row_banji = mysql_fetch_assoc($banji_result)) {
                        echo "<option value=\"" . $row_banji['班级'] . "\">" . $row_banji['班级'] . "</option>";
                    }
                    ?>
                </select>
            <form id="kc_search" name="kc_search" method="get" action="bj_rank copy.php">
                    搜索课程：<input type="text" name="in_kc" id="in_kc" placeholder="请输入考试号或考试名" />
                    <input type="text" name="in_banji" id="in_banji" hidden />
                    <?php
                    if (isset($_REQUEST['kcm'])) {
                        echo "<input type=\"hidden\"  name=\"kcm\" value=\"" . $_REQUEST['kcm'] . "\"/>";
                    }
                    ?>
                    <input type="submit" name="submit" id="submit0" value="点击搜索" />
                
            </form>
        </div>
		</p>
        <?php
        if (isset($_GET['kcm'])) {
            echo "<div id=\"jishu\">共有 ";
            echo $totalRows_cj_rank;
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
        if (isset($_GET['kcm'])) {
            echo "<script>document.getElementById(\"sss\").style.display=\"none\";</script>";
            do {
                echo "<div class=\"list1\">";
                echo "<ul>";
                echo "<li>" . (empty($row_cj_rank['姓名']) ? '-' : $row_cj_rank['姓名']) . "</li>";
                echo "<li>" . (empty($row_cj_rank['总成绩']) ? '-' : $row_cj_rank['总成绩']) . "</li>";
                echo "<li>" . (empty($row_cj_rank['总班']) ? '-' : $row_cj_rank['总班']) . "</li>";
                echo "<li>" . (empty($row_cj_rank['语']) ? '-' : $row_cj_rank['语']) . "</li>";
                echo "<li>" . (empty($row_cj_rank['数']) ? '-' : $row_cj_rank['数']) . "</li>";
                echo "<li>" . (empty($row_cj_rank['外']) ? '-' : $row_cj_rank['外']) . "</li>";
                echo "<li>" . (empty($row_cj_rank['物']) ? '-' : $row_cj_rank['物']) . "</li>";
                echo "<li>" . (empty($row_cj_rank['化']) ? '-' : $row_cj_rank['化']) . "</li>";
                echo "<li>" . (empty($row_cj_rank['生']) ? '-' : $row_cj_rank['生']) . "</li>";
                echo "<li>" . (empty($row_cj_rank['政']) ? '-' : $row_cj_rank['政']) . "</li>";
                echo "<li>" . (empty($row_cj_rank['史']) ? '-' : $row_cj_rank['史']) . "</li>";
                echo "<li>" . (empty($row_cj_rank['地']) ? '-' : $row_cj_rank['地']) . "</li>";
                echo "</ul>";
                echo "</div>";
            } while ($row_cj_rank = mysql_fetch_assoc($cj_rank));

            if ($totalRows_cj_rank == 0) {
                echo "<div class=\"list2\" style=\"text-align:center;\">目前还没有添加任何信息</div>";
            }

            echo "<div id=\"menu\">";
            if ($pageNum_cj_rank > 0 or $pageNum_cj_rank < $totalPages_cj_rank) {
                echo "<div id=\"xzys\">";
            }
            if ($pageNum_cj_rank > 0) {
                echo "<a href=\"" . sprintf("%s?kcm=%s&pageNum_cj_rank=%d", $currentPage, $_GET['kcm'], 0) . "\"><img src=\"imgs/1.png\" width=\"50px\" height=\"50px\"></a> ";
            } else {
                echo "<a><img src=\"imgs/w.png\" width=\"50px\" height=\"0px\"></a>";
            }

            if ($pageNum_cj_rank > 0) {
                echo "<a href=\"" . sprintf("%s?kcm=%s&pageNum_cj_rank=%d", $currentPage, $_GET['kcm'], max(0, $pageNum_cj_rank - 1)) . "\"><img src=\"imgs/2.png\" width=\"50px\" height=\"50px\"></a> ";
            } else {
                echo "<a><img src=\"imgs/w.png\" width=\"50px\" height=\"0px\"></a>";
            }

            if ($pageNum_cj_rank < $totalPages_cj_rank) {
                echo "<a href=\"" . sprintf("%s?kcm=%s&pageNum_cj_rank=%d", $currentPage, $_GET['kcm'], min($totalPages_cj_rank, $pageNum_cj_rank + 1)) . "\"><img src=\"imgs/3.png\" width=\"50px\" height=\"50px\"></a> ";
            } else {
                echo "<a><img src=\"imgs/w.png\" width=\"50px\" height=\"0px\"></a>";
            }

            if ($pageNum_cj_rank < $totalPages_cj_rank) {
                echo "<a href=\"" . sprintf("%s?kcm=%s&pageNum_cj_rank=%d", $currentPage, $_GET['kcm'], $totalPages_cj_rank) . "\"><img src=\"imgs/4.png\" width=\"50px\" height=\"50px\"></a> ";
            } else {
                echo "<a><img src=\"imgs/w.png\" width=\"50px\" height=\"0px\"></a>";
            }
            echo "</div></div>";
        }
        ?>
    </div>
</body>

</html>
