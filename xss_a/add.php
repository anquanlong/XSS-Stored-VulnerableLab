<?php
include "../db.php";
header("Content-Type: text/html; charset=utf-8");

if (isset($_POST['content'])) {
	if (!empty($_POST['content'])) {
		$content = trim($_POST['content']);

		// 对提交过来的内容 进行实例化存储 防止xss攻击
		//$content = htmlspecialchars($content,ENT_QUOTES);

		// 删除反斜杠\处理
		$content = stripslashes($content);

		// 转义处理 防止sql注入
		$content = mysqli_real_escape_string($conn, $content);

		// 执行数据库更新
		$sql = "INSERT INTO comment  VALUES (NULL," . time() . ",'1','$content')";
		$query = mysqli_query($conn, $sql);

		// 判断是否执行写入成功
		if ($query) {
			// 写入成功
			header("location:./index.php");
		} else {
			// 数据库写入失败
			header("location:./index.php");
		}

	} else {
		// 内容不能为空
		header("location:./index.php");
	}

}
?>
