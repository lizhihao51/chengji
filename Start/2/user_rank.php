<?php
// 引入配置文件
require_once('../../Connections/login.php');
require_once('../../Connections/is_login.php');

// 创建 mysqli 连接
$host = 'localhost';
$username = 'root'; // 替换为你的数据库用户名
$password = '15829931165'; // 替换为你的数据库密码
$database = 'marks'; // 替换为你的数据库名
$mysqli = new mysqli($host, $username, $password, $database);
if ($mysqli->connect_error) die("连接失败: ". $mysqli->connect_error);

// 分页与搜索参数
$page = isset($_GET['pageNum_cj_rank']) ? (int)$_GET['pageNum_cj_rank'] : 0;
$limit = 5;
$offset = $page * $limit;
$search = [
    'jieBie' => isset($_GET['jieBie']) ? $_GET['jieBie'] : '',
    'xingMing' => isset($_GET['xingMing']) ? $_GET['xingMing'] : '',
    'kaoShiHao' => isset($_GET['kaoShiHao']) ? $_GET['kaoShiHao'] : '',
    'xianXueNian' => isset($_COOKIE["time_xn"]) ? $_COOKIE["time_xn"] : ''
];

// 构建查询条件
$where = [];
$join = '';
foreach ($search as $key => $value) {
    if ($value) {
        $escapedValue = $mysqli->real_escape_string($value);
        switch ($key) {
            case 'jieBie':
                $where[] = "RXN LIKE '%$escapedValue%'";
                break;
            case 'xingMing':
                $where[] = "cj.XM LIKE '%$escapedValue%'";
                break;
            case 'kaoShiHao':
                $where[] = "cj.KSH = '$escapedValue'";
                break;
            case 'xianXueNian':
                $where[] = "kc.XN = '$escapedValue'";
                $join = "JOIN kc ON cj.KSH = kc.KSH";
                break;
        }
    }
}
$where = $where? "WHERE ". implode(" AND ", $where) : "";

// 计算总记录数
$countQuery = "SELECT COUNT(*) as total FROM cj $join $where";
$total = $mysqli->query($countQuery)->fetch_assoc()['total'];
$totalPages = ceil($total / $limit);

// 构建查询语句
$selectColumns = "
    cj.KSH, cj.XM, cj.BJ, cj.ZCJ, cj.ZBPM, cj.ZJPM,
    cj.YWCJ, cj.YWBP, cj.YWJP, cj.SXCJ, cj.SXBP, cj.SXJP,
    cj.WYCJ, cj.WYBP, cj.WYJP, cj.WLCJ, cj.WLBP, cj.WLJP,
    cj.HXCJ, cj.HXBP, cj.HXJP, cj.SWCJ, cj.SWBP, cj.SWJP,
    cj.ZZCJ, cj.ZZBP, cj.ZZJP, cj.LSCJ, cj.LSBP, cj.LSJP,
    cj.DLCJ, cj.DLBP, cj.DLJP,
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
";
$query = "SELECT $selectColumns FROM cj $join LEFT JOIN pjf ON cj.KSH = pjf.KSH AND cj.BJ = pjf.BJ $where 
          GROUP BY cj.KSH, cj.XM, cj.BJ, cj.ZCJ, cj.ZBPM, cj.ZJPM,
                   cj.YWCJ, cj.YWBP, cj.YWJP, cj.SXCJ, cj.SXBP, cj.SXJP,
                   cj.WYCJ, cj.WYBP, cj.WYJP, cj.WLCJ, cj.WLBP, cj.WLJP,
                   cj.HXCJ, cj.HXBP, cj.HXJP, cj.SWCJ, cj.SWBP, cj.SWJP,
                   cj.ZZCJ, cj.ZZBP, cj.ZZJP, cj.LSCJ, cj.LSBP, cj.LSJP,
                   cj.DLCJ, cj.DLBP, cj.DLJP
          LIMIT $offset, $limit";

// 执行查询
$result = $mysqli->query($query);
if (!$result) die("查询失败: ". $mysqli->error);

// 构建查询字符串
$queryStr = [];
foreach ($_GET as $key => $value) {
    if ($key!== 'pageNum_cj_rank') {
        $queryStr[$key] = $value;
    }
}
$queryStr = http_build_query($queryStr);

// 输出 JSON 数据
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['ajax'])) {
    $data = [];
    while ($row = $result->fetch_assoc()) $data[] = $row;
    header('Content-Type: application/json');
    echo json_encode(['total' => $total, 'data' => $data]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>管理员默认页</title>
    <link href="style/style.css" rel="stylesheet" type="text/css">
    <script>
        window.onload = () => {
            const xhr = new XMLHttpRequest();
            const url = `<?php echo $_SERVER["PHP_SELF"];?>?ajax=1&pageNum_cj_rank=<?php echo $page;?>&<?php echo $queryStr;?>`;
            xhr.open('GET', url, true);
            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const { total, data } = JSON.parse(xhr.responseText);
                    const resultDiv = document.getElementById('result');
                    const jishuDiv = document.getElementById('jishu');
                    jishuDiv.innerHTML = `共有 ${total} 条记录，目前显示第 ${<?php echo $offset + 1;?>} 条至第 ${Math.min(<?php echo $offset + $limit;?>, total)} 条`;
                    resultDiv.innerHTML = total === 0? '<div class="list2" style="text-align:center;">目前还没有添加任何信息</div>' :
                        data.map(row => `
                            <div class="list1">
                                <ul>
                                    <li>${row.XM || '-'}</li>
                                    <li>${row.KSH || '-'}</li>
                                    <li>${row.ZCJ || '-'}</li>
                                    <li>${row.YWCJ || '-'}</li>
                                    <li>${row.SXCJ || '-'}</li>
                                    <li>${row.WYCJ || '-'}</li>
                                    <li>${row.WLCJ || '-'}</li>
                                    <li>${row.HXCJ || '-'}</li>
                                    <li>${row.SWCJ || '-'}</li>
                                    <li>${row.ZZCJ || '-'}</li>
                                    <li>${row.LSCJ || '-'}</li>
                                    <li>${row.DLCJ || '-'}</li>
                                    <li>排名</li>
                                    <li>班/级</li>
                                    <li>${row.ZBPM || '-'}/${row.ZJPM || '-'}</li>
                                    <li>${row.YWBP || '-'}/${row.YWJP || '-'}</li>
                                    <li>${row.SXBP || '-'}/${row.SXJP || '-'}</li>
                                    <li>${row.WYBP || '-'}/${row.WYJP || '-'}</li>
                                    <li>${row.WLBP || '-'}/${row.WLJP || '-'}</li>
                                    <li>${row.HXBP || '-'}/${row.HXJP || '-'}</li>
                                    <li>${row.SWBP || '-'}/${row.SWJP || '-'}</li>
                                    <li>${row.ZZBP || '-'}/${row.ZZJP || '-'}</li>
                                    <li>${row.LSBP || '-'}/${row.LSJP || '-'}</li>
                                    <li>${row.DLBP || '-'}/${row.DLJP || '-'}</li>
                                    <li>平均分</li>
                                    <li>班/级</li>
                                    <li>暂无</li>
                                    <li>${row.YWBPJF || '-'}/${row.YWJPJF || '-'}</li>
                                    <li>${row.SXBPJF || '-'}/${row.SXJPJF || '-'}</li>
                                    <li>${row.WYBPJF || '-'}/${row.WYJPJF || '-'}</li>
                                    <li>${row.WLBPJF || '-'}/${row.WLJPJF || '-'}</li>
                                    <li>${row.HXBPJF || '-'}/${row.HXJPJF || '-'}</li>
                                    <li>${row.SWBPJF || '-'}/${row.SWJPJF || '-'}</li>
                                    <li>${row.ZZBPJF || '-'}/${row.ZZJPJF || '-'}</li>
                                    <li>${row.LSBPJF || '-'}/${row.LSJPJF || '-'}</li>
                                    <li>${row.DLBPJF || '-'}/${row.DLJPJF || '-'}</li>
                                </ul>
                            </div>
                        `).join('');
                }
            };
            xhr.send();
        };
    </script>
</head>
<body>
    <div id="box">
        <div class="search">
            <form id="cj_search" name="cj_search" method="get" action="user_rank.php">
                <p>
                    考试号：<input type="text" name="kaoShiHao" value="<?php echo htmlspecialchars($search['kaoShiHao']);?>">
                    入学年：
                    <select name="ruXueNian">
                        <option value="">请选择入学年</option>
                        <option value="2022">22</option>
                        <option value="2023">23</option>
                        <option value="2024">24</option>
                    </select>
                    姓名：<input type="text" name="xingMing" value="<?php echo htmlspecialchars($search['xingMing']);?>">
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
        <div id="jishu">正在加载数据，请稍候...</div>
        <div id="result"></div>
        <div id="menu">
            <?php if ($page > 0 || $page < $totalPages - 1):?>
                <div id="xzys">
                    <?php if ($page > 0):?>
                        <a href="<?php printf("%s?pageNum_cj_rank=%d&%s", $_SERVER["PHP_SELF"], 0, $queryStr);?>"><img src="imgs/1.png" width="50px" height="50px"></a>
                    <?php else:?>
                        <a><img src="imgs/w.png" width="50px" height="0px"></a>
                    <?php endif;?>
                    <?php if ($page > 0):?>
                        <a href="<?php printf("%s?pageNum_cj_rank=%d&%s", $_SERVER["PHP_SELF"], $page - 1, $queryStr);?>"><img src="imgs/2.png" width="50px" height="50px"></a>
                    <?php else:?>
                        <a><img src="imgs/w.png" width="50px" height="0px"></a>
                    <?php endif;?>
                    <?php if ($page + 1 < $totalPages):?>
                        <a href="<?php printf("%s?pageNum_cj_rank=%d&%s", $_SERVER["PHP_SELF"], $page + 1, $queryStr);?>"><img src="imgs/3.png" width="50px" height="50px"></a>
                    <?php else:?>
                        <a><img src="imgs/w.png" width="50px" height="0px"></a>
                    <?php endif;?>
                    <?php if ($page + 1 < $totalPages):?>
                        <a href="<?php printf("%s?pageNum_cj_rank=%d&%s", $_SERVER["PHP_SELF"], $totalPages - 1, $queryStr);?>"><img src="imgs/4.png" width="50px" height="50px"></a>
                    <?php else:?>
                        <a><img src="imgs/w.png" width="50px" height="0px"></a>
                    <?php endif;?>
                </div>
            <?php endif;?>
        </div>
    </div>
</body>
</html>