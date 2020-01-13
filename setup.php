<?php include "./db.php";
ini_set('date.timezone','Asia/Shanghai');
session_start();



if(isset($_POST['install']))
{
if($_POST['install']==1)


{	
	$sql= "TRUNCATE `comment`";
	$query=mysqli_query($conn,$sql);

}

}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>数据清除-存储型xss</title>
    <style type="text/css">
        *{margin:0;padding: 0;}
        .wrap{
            width:780px;
            height: 880px;
            margin:0 auto;
            box-shadow: 10px 10px 30px #ccc;
            border-radius: 2px;
            padding: 10px;
            position: relative;
            top: 50px;
        }
        .says{
            width:780px;
            height: 160px;
            position: absolute;
        }
        .says h1{
			margin: 20px 0 10px;
            font-size:18px;
            color:#A8A8A8;
            margin-bottom: 10px;
        }
	  
		input{
            width:150px;
            height: 40px;
            border:none;
            cursor: pointer;
            background: #00CC66;
            color:white;
            border-radius: 2px;
            position: absolute;
            left: 0;
			right: 0;
            bottom: 5px;
			margin: auto;
            transition: all ease 0.4s;
            font-size: 16px;
            outline: none;
        }
        input:hover{
            filter:alpha(opaciyt:70);
            opacity: 0.7;
        }

        a{
            font-size: 14px;
            color:#990000;
            text-decoration: none;
            margin-left: 10px;
        }
        a:hover{
            color:red;
            text-decoration: underline;
        }
        .tishi{
        	display: none;
        	position: absolute;
            left: 0;
            top: 200px;
            right: 0;
            float: left;
            width: 140px;
            height: 40px;
            line-height: 40px;
            font-size: 14px;
            color: #FFFFFF;
            background-color: rgba(0,0,0,0.7);
            margin: auto;
            text-align: center;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="wrap">
    <div class="says">
        <h1>点击下面功能按钮，执行数据库清除操作！</h1>
		<form name="form" action="./setup.php" method="post" id="form">
			<input type="hidden" value="1" name="install"/>
			<input type="button" value="清空数据库" name="setup" onclick="tishi()"/>
		</form>
    </div>
	<div class="tishi" id="tishi">数据已经成功清除!</div>
</div>
<script type='text/javascript'>
	function tishi() {
		var tishi = document.getElementById("tishi");
		form.submit();
	}
</script>

</body>
</html>
