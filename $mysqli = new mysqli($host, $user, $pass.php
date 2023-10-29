$mysqli = new mysqli($host, $user, $password, $database);

// 检查连接是否成功if ($mysqli->connect_error) {
    die('数据库连接失败: ' . $mysqli->connect_error);
}

else if ($jy != 1) {
    // 插入user表的SQL语句
    $insertQuery0 = "INSERT INTO user (username, password, unam, banji) VALUES ('$username','$password','$unam','$banji')";
    
    // 执行插入user表的SQL语句
    $result = $mysqli->query($insertQuery0);
    
    // 检查插入是否成功
    if ($result) {
        // 插入student表的SQL语句
        $insertQuery1 = "INSERT INTO student (姓名, 班级) VALUES ('$unam', '$banji')";
    
        // 执行插入student表的SQL语句
        $result0 = $mysqli->query($insertQuery1);
    
        // 检查插入是否成功
        if ($result0) {
            echo '<script>alert("用户注册成功");history.go(-1);</script>';
            exit;
        } else {
            echo '<script>alert("注册失败' . $mysqli->error . '");history.go(-1);</script>';
        }
    } else {
        echo '<script>alert("注册失败' . $mysqli->error . '");history.go(-1);</script>';
    }
}

// 关闭数据库连接
$mysqli->close();