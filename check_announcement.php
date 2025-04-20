<?php
require_once('Connections/is_login.php');
require_once('Connections/login.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $confirmation = $_POST['confirmation'];
    if ($confirmation === "我已了解不能联系万能墙要成绩") {
        $_SESSION['announcement_confirmed'] = true;

        $cookee = $_COOKIE["admin"];
        $sql = "select power from user where unam='$cookee'";
        mysql_select_db("marks", $login);
        $result = mysql_query($sql, $login);
        $row = mysql_fetch_assoc($result);
        if ($row['power'] == '2') {
            header("Location: index.php");
        } else {
            header("Location: index.php");
        }
    } else {
        header("Location: announcement.php?error=1");
    }
}
?>