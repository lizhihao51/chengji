<?php require_once('../../Connections/login.php'); ?>
<?php require_once('../../Connections/is_login.php'); ?>


<link href="style/style.css" rel="stylesheet" type="text/css">
    <div id="box">
    <div id="title3">
        <label for="cookieValue">请输入time的Cookie值:</label>
        <select id="cookieValue">
            <option value="24-25上">24-25上</option>
            <option value="24-25下">24-25下</option>
            <option value="25-26上">25-26上</option>
        </select>
        <input type="button" value="提交" onclick="setCookieValue()">
    </div>
    <script>
    function setCookieValue() {
        var cookieValue = document.getElementById('cookieValue').value;
      // 设置名为time的cookie，这里设置有效期为1天，你可以根据需要修改
      document.cookie = "time_xn=" + cookieValue + "; expires=" + new Date(Date.now() + 24 * 60 * 60 * 1000).toUTCString() + "; path=/";
        alert('Cookie已设置成功');
    }
    </script>