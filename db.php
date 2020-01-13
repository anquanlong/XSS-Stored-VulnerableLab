<?php
//连接数据库
$conn=@mysqli_connect("localhost:3306",'root','root','xss_lab') or die("数据库连接失败！".mysql_error());
?>