<?php include "../db.php";
	ini_set('date.timezone','Asia/Shanghai');
	session_start();
	$sql="select * from `comment`  WHERE `uid` = 1 order by `id` DESC";
	$query=mysqli_query($conn,$sql);
	$arr=mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	    <title>存储型XSS(普通文本框)</title>
	    <link rel="stylesheet" type="text/css" href="./assets/reset.css"/>
	    <link rel="stylesheet" type="text/css" href="./assets/index.css"/>
	</head>
	<body>
		<div class="lyb">
		    <div class="lyb-c">
		    	<div class="lyb-ct">
			        <div class="lyb-cth">来，说说你在做什么，想什么...</div>
			        <form class="lyb-ctf" name="form" action="./add.php" method="post" id="form">
						<textarea class="lyb-ctft" name="content" id='content'></textarea>
					    <div class="lyb-ctfb">
					    	<input class="lyb-ctfbb" type="button" value="发布" onclick="subLeavingMsg()">
					    </div>
			        </form>
			    </div>
			    <ul class="lyb-cu">
			        <?php foreach ($arr as $k=>$v){?>
			        	<li class="lyb-ci">
			        		<div class="lyb-cil">
			        			<?php echo $v['content'];?>
		        			</div>
			        		<div class="lyb-cir"><?php echo date('Y-m-d H:i:s', $v['time']);?></div>
		        		</li>
			        <?php } ?>
			    </ul>
		    </div>
		</div>
		<script src="./assets/filterXSS.js" type="text/javascript" charset="utf-8"></script>
		<script language="Javascript">
			// 提交留言方法
			function subLeavingMsg(){
				var form = document.getElementById('form');
				var content = document.getElementById('content');
				if (content.value == "") {
					alert("输入的内容不能为空！");
					content.focus();
					return false;
				}else{
					// 前端xss过滤
					//var html = htmlFilter(content.value); 
					//content.value = html;
					
					// 提交表单
					form.submit();
				}
			} 
			
			// XSS过滤方法
			function htmlFilter(hml) {
		        var options = {
		            whiteList: {
		                a: ["style", "class", "target", "href", "title"],
		                abbr: ["style", "class", "title"],
		                address: ["style", "class"],
		                area: ["style", "class", "shape", "coords", "href", "alt"],
		                article: ["style", "class"],
		                aside: ["style", "class"],
		                audio: ["style", "class", "autoplay", "controls", "loop", "preload", "src"],
		                b: ["style", "class"],
		                bdi: ["style", "class", "dir"],
		                bdo: ["style", "class", "dir"],
		                big: ["style", "class"],
		                blockquote: ["style", "class", "cite"],
		                br: ["style", "class"],
		                caption: ["style", "class"],
		                center: ["style", "class"],
		                cite: ["style", "class"],
		                code: ["style", "class"],
		                col: ["style", "class", "align", "valign", "span", "width"],
		                colgroup: ["style", "class", "align", "valign", "span", "width"],
		                dd: ["style", "class"],
		                del: ["style", "class", "datetime"],
		                details: ["style", "class", "open"],
		                div: ["style", "class"],
		                dl: ["style", "class"],
		                dt: ["style", "class"],
		                em: ["style", "class"],
		                font: ["style", "class", "color", "size", "face"],
		                footer: ["style", "class"],
		                h1: ["style", "class"],
		                h2: ["style", "class"],
		                h3: ["style", "class"],
		                h4: ["style", "class"],
		                h5: ["style", "class"],
		                h6: ["style", "class"],
		                header: ["style", "class"],
		                hr: ["style", "class"],
		                i: ["style", "class"],
		                img: ["style", "class", "src", "alt", "title", "width", "height"],
		                ins: ["style", "class", "datetime"],
		                li: ["style", "class"],
		                mark: ["style", "class"],
		                nav: ["style", "class"],
		                ol: ["style", "class"],
		                p: ["style", "class"],
		                pre: ["style", "class"],
		                s: ["style", "class"],
		                section: ["style", "class"],
		                small: ["style", "class"],
		                span: ["style", "class"],
		                sub: ["style", "class"],
		                sup: ["style", "class"],
		                strong: ["style", "class"],
		                table: ["style", "class", "width", "border", "align", "valign"],
		                tbody: ["style", "class", "align", "valign"],
		                td: ["style", "class", "width", "rowspan", "colspan", "align", "valign"],
		                tfoot: ["style", "class", "align", "valign"],
		                th: ["style", "class", "width", "rowspan", "colspan", "align", "valign"],
		                thead: ["style", "class", "align", "valign"],
		                tr: ["style", "class", "rowspan", "align", "valign"],
		                tt: ["style", "class"],
		                u: ["style", "class"],
		                ul: ["style", "class"],
		                video: ["style", "class", "autoplay", "controls", "loop", "preload", "src", "height", "width"]
		            },
		            stripIgnoreTag: true
		        };
		        var html = filterXSS(hml, options);
		        return html;
		    }
		</script>
    </body>
</html>
