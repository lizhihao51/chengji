<?php
require_once('Connections/is_login.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>公告页</title>
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(200deg, #e3c5eb, #a9c1ed);
            overflow: hidden;
        }

        #box {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 600px;
        }

       .announcement-content {
            text-align: center;
            margin-bottom: 20px;
        }

       .announcement-content h2 {
            color: #ff0000;
            font-size: 30px;
            margin-bottom: 10px;
        }

       .announcement-content p {
            color: #666;
            font-size: 20px;
        }

        form#announcement-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form#announcement-form input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        form#announcement-form input[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 10px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form#announcement-form input[type="submit"]:hover {
            background-color: #0056b3;
        }
        ul li{
            position: absolute;
            border: 1px solid #fff;
            background-color: #fff;
            width: 30px;
            height: 30px;
            list-style: none;
            opacity: 0;
        }
        .square li{
            top: 40vh;
            left: 60vw;
            /* 执行动画：动画名 时长 线性的 无限次播放 */
            animation: square 10s linear infinite;
        }
        .square li:nth-child(2){
            top: 80vh;
            left: 10vw;
            /* 设置动画延迟时间 */
            animation-delay: 2s;
        }
        .square li:nth-child(3){
            top: 80vh;
            left: 85vw;
            /* 设置动画延迟时间 */
            animation-delay: 4s;
        }
        .square li:nth-child(4){
            top: 10vh;
            left: 70vw;
            /* 设置动画延迟时间 */
            animation-delay: 6s;
        }
        .square li:nth-child(5){
            top: 10vh;
            left: 10vw;
            /* 设置动画延迟时间 */
            animation-delay: 8s;
        }
        .circle li{
            bottom: 0;
            left: 15vw;
            /* 执行动画 */
            animation: circle 10s linear infinite;
        }
        .circle li:nth-child(2){
            left: 35vw;
            /* 设置动画延迟时间 */
            animation-delay: 2s;
        }
        .circle li:nth-child(3){
            left: 55vw;
            /* 设置动画延迟时间 */
            animation-delay: 6s;
        }
        .circle li:nth-child(4){
            left: 75vw;
            /* 设置动画延迟时间 */
            animation-delay: 4s;
        }
        .circle li:nth-child(5){
            left: 90vw;
            /* 设置动画延迟时间 */
            animation-delay: 8s;
        }

        /* 定义动画 */
        @keyframes square {
            0%{
                transform: scale(0) rotateY(0deg);
                opacity: 1;
            }
            100%{
                transform: scale(5) rotateY(1000deg);
                opacity: 0;
            }
        }
        @keyframes circle {
            0%{
                transform: scale(0) rotateY(0deg);
                opacity: 1;
                bottom: 0;
                border-radius: 0;
            }
            100%{
                transform: scale(5) rotateY(1000deg);
                opacity: 0;
                bottom: 90vh;
                border-radius: 50%;
            }
        }


    </style>
   
   <script>
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('error') === '1') {
                alert('请检查输入内容');
            }
        };
    </script>
</head>
<body>
    <div id="box">
        <div class="announcement-content">
            <h2>重要公告</h2>
            <p>1.万能墙所有者更变，将不再提供任何关于本站服务
            <br>2.有问题请扫描主页二维码，联系作者
            <br>3.请勿在万能墙内进行询问，否则可能会引起不不要麻烦
            </p>
        </div>
        <form id="announcement-form" name="announcement-form" method="post" action="check_announcement.php">
            <input type="text" name="confirmation" id="confirmation" placeholder="请输入“我已了解不能联系万能墙要成绩”">
            <input type="submit" value="提交">
        </form>
    </div>

    <div class="square">
    <ul>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>
<div class="circle">
    <ul>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>
    
</body>
</html>