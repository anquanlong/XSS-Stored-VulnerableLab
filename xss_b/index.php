<?php include "../db.php";
	ini_set('date.timezone','Asia/Shanghai');
	session_start();
	$sql="select * from `comment`  WHERE `uid` = 2 order by `id` DESC";
	$query=mysqli_query($conn,$sql);
	$arr=mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	    <title>存储型XSS(富文本编辑器)</title>
	    <link rel="stylesheet" type="text/css" href="./assets/reset.css"/>
	    <link rel="stylesheet" type="text/css" href="./assets/index.css"/>
	</head>
	<body>
		<div class="lyb">
		    <div class="lyb-c">
		    	<div class="lyb-ct">
			        <div class="lyb-cth">来，说说你在做什么，想什么...</div>
			        <form class="lyb-ctf" name="form" action="./add.php" method="post" id="form">
						<div id="editor"></div>
					    <input type="hidden" name="content" id="content" value="" />
					    <div class="lyb-ctfb">
					    	<input class="lyb-ctfbb" type="button" value="发布" onclick="subLeavingMsg()">
					    </div>
			        </form>
			    </div>
			    <ul class="lyb-cu" id="lyb-cu">
			        <?php foreach ($arr as $k=>$v){?>
			        	<li class="lyb-ci">
			        		<div class="lyb-cil">
			        			<div class="w-e-text">
			        				<?php 
			        				echo $v['content']; 
			        				//echo htmlspecialchars_decode($v['content']);
			        				?>
			        				
			        			</div>
		        			</div>
			        		<div class="lyb-cir"><?php echo date('Y-m-d H:i:s', $v['time']);?></div>
		        		</li>
			        <?php } ?>
			    </ul>
		    </div>
		</div>
		<script src="./assets/filterXSS.js" type="text/javascript" charset="utf-8"></script>
		<script src="./assets/wangEditor.min.js" type="text/javascript" charset="utf-8"></script>
		<script language="Javascript">
			// 编辑器初始化
			var E = window.wangEditor;
	        var editor = new E('#editor');
	        // 自定义菜单配置
		    editor.customConfig.menus = [
		        'head',  // 标题
			    'bold',  // 粗体
			    'fontSize',  // 字号
			    'fontName',  // 字体
			    'italic',  // 斜体
			    'underline',  // 下划线
			    'strikeThrough',  // 删除线
			    'foreColor',  // 文字颜色
			    'backColor',  // 背景颜色
			    'link',  // 插入链接
			    'list',  // 列表
			    'justify',  // 对齐方式
			    'quote',  // 引用
			    'emoticon',  // 表情
			    'image',  // 插入图片
			    'table',  // 表格
			    //'video',  // 插入视频
			    'code',  // 插入代码
			    'undo',  // 撤销
			    'redo'  // 重复
		    ]
	        editor.create();
	        
	        // 提交留言方法
			function subLeavingMsg(){
				var form = document.getElementById('form');
				var content = document.getElementById('content');
				var editorHtml = editor.txt.html(); // 获取编辑器html内容
				var editorText = editor.txt.text(); // 获取编辑器text内容
				content.value = editorHtml;
				if (editorText == "") {
					alert("输入的内容不能为空！");
					return false;
				}else{
					// 前端xss过滤
					var html = htmlFilter(content.value); 
					editor.txt.html(html);
					
					// 提交表单
					form.submit();
				}
			} 
				
				
			// XSS过滤方法	
			function htmlFilter(hml) {
		        var options = {
		        	// 标签白名单
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
