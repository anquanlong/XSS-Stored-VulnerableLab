<?php
include "../db.php";
header("Content-Type: text/html; charset=utf-8");

if (isset($_POST['content'])) {
	if (!empty($_POST['content'])) {
		$content = trim($_POST['content']);
		
		// 对提交过来的内容 进行实例化存储 防止xss攻击
		$content = htmlspecialchars($content,ENT_QUOTES);

		// 调用XSSlab方法 对提交过来内容 进行白名单过滤 防御xss
		//$content = XSSlab($content);

		// 删除反斜杠\处理
		$content = stripslashes($content);

		// 转义处理 防止sql注入
		$content = mysqli_real_escape_string($conn, $content);

		// 执行数据库更新
		$sql = "INSERT INTO comment  VALUES (NULL," . time() . ",'2','$content')";
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
// 创建自己的xss翻译白名单过滤函数
function XSSlab($data) {
	// 引入HtmlPurifier过滤器方法
	require_once './HtmlPurifier/HTMLPurifier.auto.php';
	// 生成配置对象
	$clean_xss_config = HTMLPurifier_Config::createDefault();
	// 以下就是配置：
	$clean_xss_config -> set('Core.Encoding', 'UTF-8');
	// 设置允许使用的HTML标签
	$clean_xss_config -> set('HTML.Allowed', 'a[style|class|target|href|title],abbr[style|class|title],address[style|class],area[style|class|shape|coords|href|alt],article[style|class],aside[style|class],audio[style|class|autoplay|controls|loop|preload|src],b[style|class],bdi[style|class|dir],bdo[style|class|dir],big[style|class],blockquote[style|class|cite],br[style|class],caption[style|class],center[style|class],cite[style|class],code[style|class],col[style|class|align|valign|span|width],colgroup[style|class|align|valign|span|width],dd[style|class],del[style|class|datetime],details[style|class|open],div[style|class],dl[style|class],dt[style|class],em[style|class],font[style|class|color|size|face],footer[style|class],h1[style|class],h2[style|class],h3[style|class],h4[style|class],h5[style|class],h6[style|class],header[style|class],hr[style|class],i[style|class],img[style|class|src|alt|title|width|height],ins[style|class|datetime],li[style|class],mark[style|class],nav[style|class],ol[style|class],p[style|class],pre[style|class],s[style|class],section[style|class],small[style|class],span[style|class],sub[style|class],sup[style|class],strong[style|class],table[style|class|width|border|align|valign],tbody[style|class|align|valign],td[style|class|width|rowspan|colspan|align|valign],tfoot[style|class|align|valign],th[style|class|width|rowspan|colspan|align|valign],thead[style|class|align|valign],tr[style|class|rowspan|align|valign],tt[style|class],u[style|class],ul[style|class],video[style|class|autoplay|controls|loop|preload|src|height|width]');
	// 设置允许出现的CSS样式属性
	$clean_xss_config -> set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
	// 设置a标签上是否允许使用target="_blank"
	$clean_xss_config -> set('HTML.TargetBlank', TRUE);
	// 使用配置生成过滤用的对象
	$clean_xss_obj = new HTMLPurifier($clean_xss_config);
	// 过滤字符串
	return $clean_xss_obj -> purify($data);
}
?>

